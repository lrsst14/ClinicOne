<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientAppointmentRequest;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use LogicException;

class PatientAppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:'.CarbonImmutable::today(Appointment::TIMEZONE)->toDateString()],
        ]);
        $selectedDate = $validated['date'] ?? old('appointment_date') ?? Appointment::nextAvailableDate();
        $today = CarbonImmutable::today(Appointment::TIMEZONE)->toDateString();

        return view('pasien.pendaftaran', [
            'appointments' => $request->user()
                ->appointments()
                ->latest('appointment_date')
                ->latest('appointment_time')
                ->paginate(10)
                ->withQueryString(),
            'availableTimes' => Appointment::availableTimesFor($selectedDate),
            'minimumDate' => $today,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function store(StorePatientAppointmentRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated): void {
            $appointmentDate = CarbonImmutable::parse($validated['appointment_date'], Appointment::TIMEZONE);
            $weeklySchedule = DB::table('doctor_weekly_schedules')
                ->where('day_of_week', $appointmentDate->dayOfWeekIso)
                ->lockForUpdate()
                ->first(['is_open']);

            if (
                $weeklySchedule === null
                || ! (bool) $weeklySchedule->is_open
                || DB::table('doctor_schedule_closures')
                    ->whereDate('closed_on', $appointmentDate->toDateString())
                    ->exists()
                || ! in_array(
                    $validated['appointment_time'],
                    Appointment::availableTimesFor($validated['appointment_date']),
                    true,
                )
            ) {
                throw ValidationException::withMessages([
                    'appointment_time' => 'Slot jadwal tidak tersedia. Silakan pilih waktu lain.',
                ]);
            }

            $now = now();
            $reservationCreated = $this->reserveFutureSlot(
                $validated['appointment_date'],
                $validated['appointment_time'],
                $now,
            );

            if ($reservationCreated === 0) {
                throw ValidationException::withMessages([
                    'appointment_time' => 'Slot jadwal tidak tersedia. Silakan pilih waktu lain.',
                ]);
            }

            $appointment = $request->user()->appointments()->create([
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'complaint' => $validated['complaint'],
                'status' => Appointment::STATUS_PENDING,
            ]);

            DB::table('appointment_slot_reservations')
                ->where('appointment_date', $validated['appointment_date'])
                ->where('appointment_time', $validated['appointment_time'])
                ->update([
                    'appointment_id' => $appointment->id,
                    'updated_at' => now(),
                ]);
        });

        return to_route('pasien.pendaftaran', ['date' => $validated['appointment_date']])
            ->with('appointment_success', 'Permintaan janji berhasil dikirim dan menunggu konfirmasi dokter.');
    }

    private function reserveFutureSlot(string $date, string $time, DateTimeInterface $now): int
    {
        $connection = DB::connection();
        $bindings = [$date, $time, $now, $now, $date, $time];

        return match ($connection->getDriverName()) {
            'pgsql' => $connection->affectingStatement(
                <<<'SQL'
                    INSERT INTO appointment_slot_reservations (appointment_date, appointment_time, created_at, updated_at)
                    SELECT CAST(? AS date), CAST(? AS time), ?, ?
                    WHERE (CAST(? AS date) + CAST(? AS time)) > (clock_timestamp() AT TIME ZONE 'Asia/Jakarta')
                    ON CONFLICT (appointment_date, appointment_time) DO NOTHING
                    SQL,
                $bindings,
            ),
            'sqlite' => $connection->affectingStatement(
                <<<'SQL'
                    INSERT OR IGNORE INTO appointment_slot_reservations (appointment_date, appointment_time, created_at, updated_at)
                    SELECT ?, ?, ?, ?
                    WHERE julianday(? || ' ' || ?) > julianday(datetime('now', '+7 hours'))
                    SQL,
                $bindings,
            ),
            default => throw new LogicException('Atomic appointment slot reservation is only supported for PostgreSQL and SQLite.'),
        };
    }

    public function destroy(Request $request, Appointment $appointment): RedirectResponse
    {
        $cancelled = DB::transaction(function () use ($request, $appointment): bool {
            $patientAppointment = $request->user()
                ->appointments()
                ->whereKey($appointment->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($patientAppointment->status, [
                Appointment::STATUS_PENDING,
                Appointment::STATUS_CONFIRMED,
            ], true)) {
                return false;
            }

            DB::table('appointment_slot_reservations')
                ->where('appointment_id', $patientAppointment->id)
                ->delete();

            $patientAppointment->update([
                'status' => Appointment::STATUS_CANCELLED,
            ]);

            return true;
        }, attempts: 3);

        if (! $cancelled) {
            return back()->withErrors([
                'appointment' => 'Janji ini sudah tidak dapat dibatalkan.',
            ]);
        }

        return to_route('pasien.pendaftaran')
            ->with('appointment_success', 'Janji berhasil dibatalkan.');
    }
}
