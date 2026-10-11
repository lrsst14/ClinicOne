<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDoctorScheduleRequest;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\DoctorScheduleClosure;
use App\Models\DoctorWeeklySchedule;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DoctorScheduleController extends Controller
{
    private const DAYS = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];

    public function index(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return to_route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $today = CarbonImmutable::today(Appointment::TIMEZONE);
        $weeklySchedules = DoctorWeeklySchedule::query()
            ->orderBy('day_of_week')
            ->get()
            ->keyBy('day_of_week');
        $todaySchedule = $weeklySchedules->get($today->dayOfWeekIso);
        $isClosedToday = DoctorScheduleClosure::query()
            ->whereDate('closed_on', $today->toDateString())
            ->exists();
        $isOpenToday = $todaySchedule?->is_open === true && ! $isClosedToday;
        $now = CarbonImmutable::now(Appointment::TIMEZONE);
        $reservedTimes = DB::table('appointment_slot_reservations')
            ->whereDate('appointment_date', $today->toDateString())
            ->pluck('appointment_time')
            ->map(static fn (string $time): string => substr($time, 0, 5))
            ->all();
        $slotAvailability = collect(Appointment::scheduledTimesFor($today->toDateString()))
            ->map(static fn (string $time): array => [
                'time' => $time,
                'is_reserved' => in_array($time, $reservedTimes, true),
                'is_expired' => $today->setTimeFromTimeString($time)->lessThanOrEqualTo($now),
            ]);
        $profile = DoctorProfile::query()->first();

        return view('dokter.pengaturan-jadwal', [
            'days' => self::DAYS,
            'weeklySchedules' => $weeklySchedules,
            'todaySchedule' => $todaySchedule,
            'today' => $today,
            'isOpenToday' => $isOpenToday,
            'isScheduledToday' => $todaySchedule?->is_open === true,
            'clinicIsOpenToday' => $isOpenToday,
            'clinicTodaySchedule' => $todaySchedule,
            'slotAvailability' => $slotAvailability,
            'availableSlotCount' => $isOpenToday
                ? $slotAvailability->where('is_reserved', false)->where('is_expired', false)->count()
                : 0,
            'reservedSlotCount' => $slotAvailability->where('is_reserved', true)->count(),
            'practiceDayCount' => $weeklySchedules->where('is_open', true)->count(),
            'profile' => $profile,
            'doctorDisplayName' => trim(($profile?->title ?: 'dr.').' '.($profile?->full_name ?: 'Andi')),
            'doctorSpecialization' => $profile?->specialization ?: 'Dokter Umum',
        ]);
    }

    public function update(UpdateDoctorScheduleRequest $request): RedirectResponse
    {
        $validatedSchedule = $request->validated('schedule');

        DB::transaction(function () use ($validatedSchedule): void {
            DoctorWeeklySchedule::query()
                ->orderBy('day_of_week')
                ->lockForUpdate()
                ->get();

            $today = CarbonImmutable::today(Appointment::TIMEZONE);
            $appointments = Appointment::query()
                ->whereDate('appointment_date', '>=', $today->toDateString())
                ->whereIn('status', [
                    Appointment::STATUS_PENDING,
                    Appointment::STATUS_CONFIRMED,
                ])
                ->get(['appointment_date', 'appointment_time']);

            foreach ($appointments as $appointment) {
                $dayOfWeek = $appointment->appointment_date->dayOfWeekIso;
                $dailySchedule = $validatedSchedule[$dayOfWeek] ?? null;

                if (! is_array($dailySchedule) || ! filter_var($dailySchedule['is_open'] ?? null, FILTER_VALIDATE_BOOLEAN)) {
                    throw ValidationException::withMessages([
                        'schedule' => 'Perubahan jadwal berbenturan dengan janji pasien yang masih aktif.',
                    ]);
                }

                $startTime = $dailySchedule['start_time'] ?? null;
                $endTime = $dailySchedule['end_time'] ?? null;
                $appointmentTime = substr($appointment->appointment_time, 0, 5);

                if (
                    ! is_string($startTime)
                    || ! is_string($endTime)
                    || $appointmentTime < $startTime
                    || $appointmentTime >= $endTime
                ) {
                    throw ValidationException::withMessages([
                        'schedule' => 'Perubahan jam berbenturan dengan janji pasien yang masih aktif.',
                    ]);
                }
            }

            foreach (self::DAYS as $dayOfWeek => $_dayName) {
                $day = $validatedSchedule[$dayOfWeek];
                $isOpen = filter_var($day['is_open'], FILTER_VALIDATE_BOOLEAN);

                DoctorWeeklySchedule::query()
                    ->where('day_of_week', $dayOfWeek)
                    ->update([
                        'is_open' => $isOpen,
                        'start_time' => $day['start_time'] ?? null,
                        'end_time' => $day['end_time'] ?? null,
                        'updated_at' => now(),
                    ]);
            }
        }, attempts: 3);

        return to_route('dokter.jadwal')
            ->with('schedule_success', 'Jadwal praktik berhasil disimpan.');
    }

    public function updateTodayStatus(Request $request): RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return to_route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $validated = $request->validate([
            'status' => ['required', 'in:open,closed'],
        ]);
        $today = CarbonImmutable::today(Appointment::TIMEZONE);
        $statusChanged = DB::transaction(function () use ($validated, $today): bool {
            $weeklySchedule = DoctorWeeklySchedule::query()
                ->where('day_of_week', $today->dayOfWeekIso)
                ->lockForUpdate()
                ->firstOrFail();

            if (! $weeklySchedule->is_open) {
                return false;
            }

            if ($validated['status'] === 'closed') {
                DoctorScheduleClosure::query()->firstOrCreate([
                    'closed_on' => $today->toDateString(),
                ]);
            } else {
                DoctorScheduleClosure::query()
                    ->whereDate('closed_on', $today->toDateString())
                    ->delete();
            }

            return true;
        }, attempts: 3);

        if (! $statusChanged) {
            return to_route('dokter.jadwal')->withErrors([
                'status' => 'Hari ini libur sesuai jadwal praktik mingguan.',
            ]);
        }

        return to_route('dokter.jadwal')->with(
            'schedule_success',
            $validated['status'] === 'closed'
                ? 'Penerimaan janji ditutup untuk hari ini. Jadwal mingguan tidak berubah.'
                : 'Penerimaan janji dibuka kembali sesuai jadwal mingguan.',
        );
    }
}
