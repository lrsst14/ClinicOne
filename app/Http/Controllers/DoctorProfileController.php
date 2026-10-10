<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DoctorProfileController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $profile = DoctorProfile::query()->firstOrCreate([]);

        return view('dokter.profil', ['profile' => $profile]);
    }

    public function showForPatients(): View
    {
        return view('pasien.profil-dokter', [
            'profile' => DoctorProfile::query()->first(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:30'],
            'specialization' => ['required', 'string', 'max:255'],
            'str_number' => ['nullable', 'string', 'max:64'],
            'sip_number' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'specialization.required' => 'Spesialisasi wajib diisi.',
            'email.email' => 'Format email kontak tidak valid.',
            'photo.image' => 'Foto profil harus berupa gambar.',
            'photo.mimes' => 'Foto profil hanya boleh menggunakan JPG atau PNG.',
            'photo.max' => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        $profile = DoctorProfile::query()->firstOrCreate([]);
        $oldPhotoPath = $profile->photo_path;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->storePublicly('doctor-profile', 'public');

            if (! is_string($photoPath)) {
                throw new RuntimeException('Foto profil gagal disimpan ke storage publik.');
            }

            $profile->photo_path = $photoPath;
        }

        $profile->fill([
            'full_name' => $validated['full_name'],
            'title' => $validated['title'] ?? null,
            'specialization' => $validated['specialization'],
            'str_number' => $validated['str_number'] ?? null,
            'sip_number' => $validated['sip_number'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);
        $profile->save();

        if ($request->hasFile('photo') && is_string($oldPhotoPath) && ! Storage::disk('public')->delete($oldPhotoPath)) {
            Log::warning('Dokter profile photo could not be removed after replacement.', [
                'doctor_profile_id' => $profile->id,
                'photo_path' => $oldPhotoPath,
            ]);
        }

        return to_route('dokter.profil')->with('profile_updated', 'Informasi profil berhasil disimpan.');
    }

    public function updateAccessCode(Request $request): RedirectResponse
    {
        if (! $request->session()->get('doctor_authenticated')) {
            return redirect()->route('dokter.login')->withErrors([
                'access_code' => 'Silakan masuk terlebih dahulu.',
            ]);
        }

        $validated = $request->validate([
            'current_access_code' => ['required', 'string', 'min:4'],
            'new_access_code' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_access_code.required' => 'Kode akses saat ini wajib diisi.',
            'new_access_code.required' => 'Kode akses baru wajib diisi.',
            'new_access_code.min' => 'Kode akses baru minimal 8 karakter.',
            'new_access_code.confirmed' => 'Konfirmasi kode akses baru tidak cocok.',
        ]);

        $profile = DoctorProfile::query()->firstOrCreate([]);
        $accessCodeHash = $profile->access_code_hash;
        $legacyAccessCode = config('services.clinicone.doctor_access_code');
        $isCurrentCodeValid = is_string($accessCodeHash)
            ? Hash::check($validated['current_access_code'], $accessCodeHash)
            : is_string($legacyAccessCode)
                && hash_equals($legacyAccessCode, $validated['current_access_code']);

        if (! $isCurrentCodeValid) {
            return back()->withErrors([
                'current_access_code' => 'Kode akses saat ini tidak valid.',
            ]);
        }

        $profile->access_code_hash = Hash::make($validated['new_access_code']);
        $profile->save();

        return to_route('dokter.profil')->with('access_code_updated', 'Kode akses berhasil diubah.');
    }

    public function photo(): BinaryFileResponse
    {
        $photoPath = DoctorProfile::query()->value('photo_path');

        abort_unless(is_string($photoPath) && Storage::disk('public')->exists($photoPath), 404);

        return response()->file(Storage::disk('public')->path($photoPath));
    }
}
