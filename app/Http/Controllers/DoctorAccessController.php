<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DoctorAccessController extends Controller
{
    public function showLoginForm(Request $request): View|RedirectResponse
    {
        if ($request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.dashboard');
        }

        return view('dokter.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'access_code' => ['required', 'string', 'min:4'],
        ], [
            'access_code.required' => 'Kode akses wajib diisi.',
            'access_code.min' => 'Kode akses minimal 4 karakter.',
        ]);

        $doctorProfile = DoctorProfile::query()->first();
        $accessCodeHash = $doctorProfile?->access_code_hash;

        $isValidAccessCode = is_string($accessCodeHash)
            ? Hash::check($validated['access_code'], $accessCodeHash)
            : is_string(config('services.clinicone.doctor_access_code'))
                && hash_equals(config('services.clinicone.doctor_access_code'), $validated['access_code']);

        if (! $isValidAccessCode) {
            return back()
                ->withErrors(['access_code' => 'Kode akses tidak valid. Silakan cek kembali.'])
                ->withInput();
        }

        $request->session()->put('doctor_authenticated', true);

        return redirect()->route('dokter.dashboard');
    }

    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $today = CarbonImmutable::today(Appointment::TIMEZONE);
        $todayAppointments = Appointment::query()
            ->whereDate('appointment_date', $today->toDateString())
            ->get(['id', 'status']);
        $appointments = Appointment::query()
            ->with('patient:id,name')
            ->whereDate('appointment_date', '>=', $today->toDateString())
            ->limit(10)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->orderBy('id')
            ->get();

        $activeAppointments = $todayAppointments->whereIn('status', Appointment::ACTIVE_STATUSES);
        $dailySlotCapacity = match ($today->dayOfWeekIso) {
            1, 2, 3, 4 => 8,
            5 => 6,
            default => 0,
        };

        return view('dokter.dashboard', [
            'appointments' => $appointments,
            'appointmentCount' => $activeAppointments->count(),
            'waitingAppointmentCount' => $activeAppointments->where('status', Appointment::STATUS_PENDING)->count(),
            'completedAppointmentCount' => $activeAppointments->where('status', Appointment::STATUS_COMPLETED)->count(),
            'availableSlotCount' => max(0, $dailySlotCapacity - $activeAppointments->count()),
            'dashboardDate' => $today->locale('id')->translatedFormat('l, j F Y'),
        ]);
    }

    public function kelolaJanji(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        return view('dokter.kelola-janji');
    }

    public function pengaturanJadwal(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        return view('dokter.pengaturan-jadwal');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('doctor_authenticated');

        return redirect()->route('dokter.login');
    }
}
