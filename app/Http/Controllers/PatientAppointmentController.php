<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientAppointmentRequest;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\DoctorScheduleClosure;
use App\Models\DoctorWeeklySchedule;
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
    public function dashboard(Request $request): View
    {
        $patient = $request->user();
        $today = CarbonImmutable::today(Appointment::TIMEZONE);
        $now = CarbonImmutable::now(Appointment::TIMEZONE);
        $upcomingStatuses = [Appointment::STATUS_PENDING, Appointment::STATUS_CONFIRMED];
        $upcomingAppointment = $patient->appointments()
            ->whereDate('appointment_date', '>=', $today->toDateString())
            ->whereIn('status', $upcomingStatuses)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();
        $completedAppointments = $patient->appointments()
            ->where('status', Appointment::STATUS_COMPLETED);
        $completedCount = (clone $completedAppointments)->count();
        $latestCompletedAppointment = (clone $completedAppointments)
            ->latest('appointment_date')
            ->latest('appointment_time')
            ->first();
        $doctorProfile = DoctorProfile::query()->first();
        $todaySchedule = DoctorWeeklySchedule::query()
            ->where('day_of_week', $today->dayOfWeekIso)
            ->first();
        $clinicIsOpen = $todaySchedule?->is_open
            && is_string($todaySchedule->start_time)
            && is_string($todaySchedule->end_time)
            && $now->format('H:i:s') >= $todaySchedule->start_time
            && $now->format('H:i:s') < $todaySchedule->end_time
            && ! DoctorScheduleClosure::query()->whereDate('closed_on', $today->toDateString())->exists();

        return view('pasien.dashboard', [
            'completedCount' => $completedCount,
            'doctorProfile' => $doctorProfile,
            'doctorDisplayName' => $this->doctorDisplayName($doctorProfile),
            'doctorPhotoUrl' => $doctorProfile?->photo_path
                ? route('dokter.profil.photo')
                : asset('img/Doctor_portrait.png'),
            'doctorSpecialization' => $doctorProfile?->specialization ?: 'Spesialisasi belum tersedia.',
            'latestCompletedAppointment' => $latestCompletedAppointment,
            'patientAppointmentCount' => $patient->appointments()->count(),
            'recentAppointments' => (clone $completedAppointments)
                ->latest('appointment_date')
                ->latest('appointment_time')
                ->limit(2)
                ->get(),
            'today' => $today,
            'todaySchedule' => $todaySchedule,
            'clinicIsOpen' => $clinicIsOpen,
            'upcomingAppointment' => $upcomingAppointment,
            'upcomingAppointmentCount' => $patient->appointments()
                ->whereDate('appointment_date', '>=', $today->toDateString())
                ->whereIn('status', $upcomingStatuses)
                ->count(),
            'appointmentStatusLabels' => $this->appointmentStatusLabels(),
        ]);
    }

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:'.CarbonImmutable::today(Appointment::TIMEZONE)->toDateString()],
        ]);
        $selectedDate = $validated['date'] ?? old('appointment_date') ?? Appointment::nextAvailableDate();
        $today = CarbonImmutable::today(Appointment::TIMEZONE)->toDateString();
        $appointmentDate = CarbonImmutable::parse($selectedDate, Appointment::TIMEZONE);
        $doctorProfile = DoctorProfile::query()->first();
        $todaySchedule = DoctorWeeklySchedule::query()
            ->where('day_of_week', CarbonImmutable::today(Appointment::TIMEZONE)->dayOfWeekIso)
            ->first();

        return view('pasien.pendaftaran', [
            'appointments' => $request->user()
                ->appointments()
                ->latest('appointment_date')
                ->latest('appointment_time')
                ->paginate(10)
                ->withQueryString(),
            'availableTimes' => Appointment::availableTimesFor($selectedDate),
            'doctorProfile' => $doctorProfile,
            'doctorDisplayName' => $this->doctorDisplayName($doctorProfile),
            'minimumDate' => $today,
            'selectedDate' => $selectedDate,
            'todaySchedule' => $todaySchedule,
            'doctorPhotoUrl' => $doctorProfile?->photo_path
                ? route('dokter.profil.photo')
                : asset('img/Doctor_portrait.png'),
            'doctorSpecialization' => $doctorProfile?->specialization ?: 'Spesialisasi belum tersedia.',
            'selectedDaySchedule' => DoctorWeeklySchedule::query()
                ->where('day_of_week', $appointmentDate->dayOfWeekIso)
                ->first(),
        ]);
    }

    public function schedule(Request $request): View
    {
        $today = CarbonImmutable::today(Appointment::TIMEZONE);
        $now = CarbonImmutable::now(Appointment::TIMEZONE);
        $lastDate = $today->addDays(369);
        $weekStart = $today->startOfWeek(CarbonImmutable::MONDAY);
        $weeklySchedules = DoctorWeeklySchedule::query()
            ->orderBy('day_of_week')
            ->get()
            ->mapWithKeys(static fn (DoctorWeeklySchedule $schedule): array => [
                $schedule->day_of_week => [
                    'is_open' => $schedule->is_open,
                    'start_time' => $schedule->start_time ? substr($schedule->start_time, 0, 5) : null,
                    'end_time' => $schedule->end_time ? substr($schedule->end_time, 0, 5) : null,
                ],
            ]);
        $reservationsByDate = DB::table('appointment_slot_reservations')
            ->whereBetween('appointment_date', [$today->toDateString(), $lastDate->toDateString()])
            ->get(['appointment_date', 'appointment_time'])
            ->groupBy(static fn (object $reservation): string => CarbonImmutable::parse($reservation->appointment_date, Appointment::TIMEZONE)->toDateString())
            ->map(static fn ($reservations): array => $reservations
                ->map(static fn (object $reservation): string => substr($reservation->appointment_time, 0, 5))
                ->all());
        $closedDates = DoctorScheduleClosure::query()
            ->whereBetween('closed_on', [$today->toDateString(), $lastDate->toDateString()])
            ->get(['closed_on'])
            ->map(static fn (DoctorScheduleClosure $closure): string => $closure->closed_on->toDateString())
            ->all();
        $upcomingStatuses = [Appointment::STATUS_PENDING, Appointment::STATUS_CONFIRMED];
        $upcomingAppointments = $request->user()->appointments()
            ->whereBetween('appointment_date', [$today->toDateString(), $lastDate->toDateString()])
            ->whereIn('status', $upcomingStatuses)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get(['id', 'appointment_date', 'appointment_time', 'status', 'complaint']);
        $patientAppointmentsBySlot = $upcomingAppointments
            ->mapWithKeys(static fn (Appointment $appointment): array => [
                $appointment->appointment_date->toDateString().'|'.substr($appointment->appointment_time, 0, 5) => true,
            ]);
        $nextAvailableDate = Appointment::nextAvailableDate();
        $nextAvailableTime = Appointment::availableTimesFor($nextAvailableDate)[0] ?? null;
        $selectedAppointment = $upcomingAppointments->first();
        $todaySchedule = $weeklySchedules->get($today->dayOfWeekIso);
        $clinicIsOpen = $todaySchedule !== null
            && $todaySchedule['is_open']
            && is_string($todaySchedule['start_time'])
            && is_string($todaySchedule['end_time'])
            && $now->format('H:i') >= $todaySchedule['start_time']
            && $now->format('H:i') < $todaySchedule['end_time']
            && ! in_array($today->toDateString(), $closedDates, true);

        $doctorProfile = DoctorProfile::query()->first();

        return view('pasien.jadwal-dokter', [
            'clinicIsOpen' => $clinicIsOpen,
            'closedDates' => $closedDates,
            'doctorProfile' => $doctorProfile,
            'doctorDisplayName' => $this->doctorDisplayName($doctorProfile),
            'doctorPhotoUrl' => $doctorProfile?->photo_path
                ? route('dokter.profil.photo')
                : asset('img/Doctor_portrait.png'),
            'doctorSpecialization' => $doctorProfile?->specialization ?: 'Spesialisasi belum tersedia.',
            'nextAvailableDate' => $nextAvailableTime === null ? null : $nextAvailableDate,
            'nextAvailableTime' => $nextAvailableTime,
            'patientAppointmentsBySlot' => $patientAppointmentsBySlot->all(),
            'reservationsByDate' => $reservationsByDate->all(),
            'selectedAppointment' => $selectedAppointment,
            'today' => $today->toDateString(),
            'todaySchedule' => $todaySchedule,
            'weekStart' => $weekStart->toDateString(),
            'weeklySchedules' => $weeklySchedules->all(),
            'nowTime' => $now->format('H:i'),
            'lastDate' => $lastDate->toDateString(),
            'appointmentStatusLabels' => $this->appointmentStatusLabels(),
        ]);
    }

    public function history(Request $request): View
    {
        $doctorProfile = DoctorProfile::query()->first();
        $today = CarbonImmutable::today(Appointment::TIMEZONE);

        return view('pasien.riwayat', [
            'appointments' => $request->user()->appointments()
                ->latest('appointment_date')
                ->latest('appointment_time')
                ->get(),
            'doctorProfile' => $doctorProfile,
            'doctorDisplayName' => $this->doctorDisplayName($doctorProfile),
            'patient' => $request->user(),
            'doctorPhotoUrl' => $doctorProfile?->photo_path
                ? route('dokter.profil.photo')
                : asset('img/Doctor_portrait.png'),
            'doctorSpecialization' => $doctorProfile?->specialization ?: 'Spesialisasi belum tersedia.',
            'todaySchedule' => DoctorWeeklySchedule::query()
                ->where('day_of_week', $today->dayOfWeekIso)
                ->first(),
            'statusLabels' => $this->appointmentStatusLabels(),
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function appointmentStatusLabels(): array
    {
        return [
            Appointment::STATUS_PENDING => 'Menunggu',
            Appointment::STATUS_CONFIRMED => 'Dikonfirmasi',
            Appointment::STATUS_REJECTED => 'Ditolak',
            Appointment::STATUS_COMPLETED => 'Selesai',
            Appointment::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    private function doctorDisplayName(?DoctorProfile $profile): string
    {
        return trim(($profile?->title ? $profile->title.' ' : '').($profile?->full_name ?? ''))
            ?: 'Profil dokter belum tersedia';
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
