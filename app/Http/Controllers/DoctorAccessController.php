<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        $expectedCode = config('services.clinicone.doctor_access_code', env('DOCTOR_ACCESS_CODE', 'clinicone2026'));

        if (! is_string($expectedCode) || ! hash_equals($expectedCode, (string) $validated['access_code'])) {
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

        return view('dokter.dashboard');
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

    public function profilDokter(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        return view('dokter.profil');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('doctor_authenticated');

        return redirect()->route('dokter.login');
    }
}
