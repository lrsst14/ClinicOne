<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorAppointmentRequest;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DoctorAppointmentController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return to_route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', 'in:all,pending,confirmed,rejected,completed,cancelled'],
        ]);

        $countsByStatus = Appointment::query()
            ->selectRaw('status, COUNT(*) AS aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $stats = [
            'total' => (int) $countsByStatus->sum(),
            'pending' => (int) $countsByStatus->get(Appointment::STATUS_PENDING, 0),
            'confirmed' => (int) $countsByStatus->get(Appointment::STATUS_CONFIRMED, 0),
            'completed' => (int) $countsByStatus->get(Appointment::STATUS_COMPLETED, 0),
        ];

        $appointments = Appointment::query()
            ->with('patient')
            ->when($validated['search'] ?? null, function (Builder $query, string $search): void {
                $query->whereHas('patient', function (Builder $patientQuery) use ($search): void {
                    $patientQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when($validated['date'] ?? null, fn (Builder $query, string $date) => $query->whereDate('appointment_date', $date))
            ->when(
                isset($validated['status']) && $validated['status'] !== 'all',
                fn (Builder $query) => $query->where('status', $validated['status']),
            )
            ->orderByDesc('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(15)
            ->withQueryString();

        return view('dokter.janji-database', [
            'appointments' => $appointments,
            'filters' => $validated,
            'profile' => DoctorProfile::query()->first(),
            'stats' => $stats,
        ]);
    }

    public function update(UpdateDoctorAppointmentRequest $request, Appointment $appointment): RedirectResponse
    {
        $newStatus = $request->validated('status');
        DB::transaction(function () use ($appointment, $newStatus): void {
            $lockedAppointment = Appointment::query()
                ->whereKey($appointment->getKey())
                ->lockForUpdate()
                ->firstOrFail();
            $allowedTransitions = match ($lockedAppointment->status) {
                Appointment::STATUS_PENDING => [
                    Appointment::STATUS_CONFIRMED,
                    Appointment::STATUS_REJECTED,
                ],
                Appointment::STATUS_CONFIRMED => [
                    Appointment::STATUS_COMPLETED,
                ],
                default => [],
            };

            if (! in_array($newStatus, $allowedTransitions, true)) {
                throw ValidationException::withMessages([
                    'status' => 'Perubahan status janji ini tidak diizinkan.',
                ]);
            }

            if ($newStatus === Appointment::STATUS_COMPLETED && ! $lockedAppointment->canBeMarkedCompleted()) {
                throw ValidationException::withMessages([
                    'status' => 'Janji hanya dapat ditandai selesai setelah waktu pemeriksaan.',
                ]);
            }

            if (in_array($newStatus, [
                Appointment::STATUS_REJECTED,
                Appointment::STATUS_COMPLETED,
            ], true)) {
                DB::table('appointment_slot_reservations')
                    ->where('appointment_id', $lockedAppointment->id)
                    ->delete();
            }

            $lockedAppointment->update([
                'status' => $newStatus,
            ]);
        }, attempts: 3);

        return to_route('dokter.janji')
            ->with('appointment_success', 'Status janji berhasil diperbarui.');
    }
}
