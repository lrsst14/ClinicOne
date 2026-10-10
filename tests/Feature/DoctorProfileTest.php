<?php

namespace Tests\Feature;

use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DoctorProfileTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_doctor_can_view_and_update_profile_details(): void
    {
        $this->withoutVite();

        $this->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.profil'))
            ->assertOk()
            ->assertViewHas('profile');

        $response = $this->withSession(['doctor_authenticated' => true])
            ->post(route('dokter.profil.update'), [
                'full_name' => 'Andi Pratama',
                'title' => 'dr.',
                'specialization' => 'Dokter Umum',
                'str_number' => 'STR12345',
                'sip_number' => 'SIP12345',
                'phone' => '081234567890',
                'email' => 'andi@example.test',
                'bio' => 'Melayani konsultasi kesehatan umum.',
            ]);

        $response->assertRedirect(route('dokter.profil'))
            ->assertSessionHas('profile_updated', 'Informasi profil berhasil disimpan.');
        $this->assertDatabaseHas('doctor_profiles', [
            'full_name' => 'Andi Pratama',
            'title' => 'dr.',
            'specialization' => 'Dokter Umum',
            'str_number' => 'STR12345',
            'sip_number' => 'SIP12345',
            'phone' => '081234567890',
            'email' => 'andi@example.test',
            'bio' => 'Melayani konsultasi kesehatan umum.',
        ]);
    }

    public function test_doctor_can_upload_a_profile_photo_to_public_storage(): void
    {
        Storage::fake('public');

        $response = $this->withSession(['doctor_authenticated' => true])
            ->post(route('dokter.profil.update'), [
                'full_name' => 'Andi Pratama',
                'specialization' => 'Dokter Umum',
                'photo' => UploadedFile::fake()->create('doctor.jpg', 10, 'image/jpeg'),
            ]);

        $response->assertRedirect(route('dokter.profil'));

        $profile = DoctorProfile::query()->firstOrFail();
        $this->assertNotNull($profile->photo_path);
        Storage::disk('public')->assertExists($profile->photo_path);

        $this->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.profil.photo'))
            ->assertOk();
    }

    public function test_profile_update_validates_input_and_does_not_save_invalid_data(): void
    {
        $response = $this->withSession(['doctor_authenticated' => true])
            ->from(route('dokter.profil'))
            ->post(route('dokter.profil.update'), [
                'full_name' => '',
                'specialization' => 'Dokter Umum',
                'email' => 'not-an-email',
            ]);

        $response->assertRedirect(route('dokter.profil'))
            ->assertSessionHasErrors(['full_name', 'email']);
        $this->assertDatabaseCount('doctor_profiles', 0);
    }

    public function test_doctor_can_change_access_code_and_log_in_with_the_new_code(): void
    {
        config(['services.clinicone.doctor_access_code' => 'clinicone2026']);

        $response = $this->withSession(['doctor_authenticated' => true])
            ->post(route('dokter.profil.access-code'), [
                'current_access_code' => 'clinicone2026',
                'new_access_code' => 'secure-code-2030',
                'new_access_code_confirmation' => 'secure-code-2030',
            ]);

        $response->assertRedirect(route('dokter.profil'))
            ->assertSessionHas('access_code_updated', 'Kode akses berhasil diubah.');

        $profile = DoctorProfile::query()->firstOrFail();
        $this->assertTrue(Hash::check('secure-code-2030', $profile->access_code_hash));
        $this->assertNotSame('secure-code-2030', $profile->access_code_hash);

        $this->flushSession()
            ->from(route('dokter.login'))
            ->post(route('dokter.login.submit'), ['access_code' => 'clinicone2026'])
            ->assertRedirect(route('dokter.login'))
            ->assertSessionHasErrors(['access_code']);

        $this->flushSession()
            ->post(route('dokter.login.submit'), ['access_code' => 'secure-code-2030'])
            ->assertRedirect(route('dokter.dashboard'))
            ->assertSessionHas('doctor_authenticated', true);
    }

    public function test_doctor_cannot_change_access_code_with_an_invalid_current_code(): void
    {
        config(['services.clinicone.doctor_access_code' => 'clinicone2026']);

        $response = $this->withSession(['doctor_authenticated' => true])
            ->from(route('dokter.profil'))
            ->post(route('dokter.profil.access-code'), [
                'current_access_code' => 'wrong-code',
                'new_access_code' => 'secure-code-2030',
                'new_access_code_confirmation' => 'secure-code-2030',
            ]);

        $response->assertRedirect(route('dokter.profil'))
            ->assertSessionHasErrors(['current_access_code']);
        $this->assertDatabaseCount('doctor_profiles', 1);
        $this->assertNull(DoctorProfile::query()->firstOrFail()->access_code_hash);
    }

    public function test_patient_profile_displays_the_doctors_saved_public_details(): void
    {
        DoctorProfile::query()->create([
            'full_name' => 'Andi Pratama',
            'title' => 'dr.',
            'specialization' => 'Dokter Umum',
            'bio' => 'Melayani konsultasi keluarga.',
        ]);
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->get(route('pasien.profil-dokter'))
            ->assertOk()
            ->assertSee('dr. Andi Pratama')
            ->assertSee('Dokter Umum')
            ->assertSee('Melayani konsultasi keluarga.');
    }

    public function test_doctor_profile_updates_require_doctor_authentication(): void
    {
        $this->post(route('dokter.profil.update'), [
            'full_name' => 'Unauthorized Update',
            'specialization' => 'Dokter Umum',
        ])->assertRedirect(route('dokter.login'));

        $this->assertDatabaseCount('doctor_profiles', 0);
    }
}
