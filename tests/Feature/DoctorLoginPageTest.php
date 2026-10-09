<?php

namespace Tests\Feature;

use Tests\TestCase;

class DoctorLoginPageTest extends TestCase
{
    public function test_doctor_login_page_is_available_at_home_and_doctor_url(): void
    {
        $this->withoutVite();

        foreach (['/', '/dokter'] as $uri) {
            $this->get($uri)
                ->assertOk()
                ->assertSee('Login Dokter')
                ->assertSee('Kode Akses')
                ->assertSee('Halaman ini khusus untuk dokter/admin klinik.');
        }
    }

    public function test_doctor_can_login_with_valid_access_code(): void
    {
        $this->withoutVite();

        $response = $this->from('/dokter')->post('/dokter/login', ['access_code' => 'clinicone2026']);

        $response->assertRedirect('/dokter/dashboard');
        $this->assertTrue(session('doctor_authenticated'));
    }

    public function test_doctor_cannot_login_with_invalid_access_code(): void
    {
        $this->withoutVite();

        $response = $this->from('/dokter')->post('/dokter/login', ['access_code' => 'salah']);

        $response->assertRedirect('/dokter');
        $response->assertSessionHasErrors(['access_code' => 'Kode akses tidak valid. Silakan cek kembali.']);
    }

    public function test_doctor_can_open_kelola_janji_page_after_login(): void
    {
        $this->withoutVite();

        $this->withSession(['doctor_authenticated' => true])
            ->get('/dokter/janji')
            ->assertOk()
            ->assertSee('Kelola Janji')
            ->assertSee('Daftar Janji Pasien')
            ->assertSee('data-appointment-details', false)
            ->assertSee('appointment-detail-modal', false)
            ->assertSee('Detail Janji');
    }

    public function test_doctor_can_open_pengaturan_jadwal_page_after_login(): void
    {
        $this->withoutVite();

        $this->withSession(['doctor_authenticated' => true])
            ->get('/dokter/jadwal')
            ->assertOk()
            ->assertSee('Pengaturan Jadwal')
            ->assertSee('Jadwal Praktik Mingguan');
    }

    public function test_doctor_can_open_profile_page_after_login(): void
    {
        $this->withoutVite();

        $this->withSession(['doctor_authenticated' => true])
            ->get('/dokter/profil')
            ->assertOk()
            ->assertSee('Profil Dokter')
            ->assertSee('Informasi Dokter')
            ->assertSee('Keamanan Akun');
    }

    public function test_profile_page_redirects_unauthenticated_doctor_to_login(): void
    {
        $this->get('/dokter/profil')
            ->assertRedirect('/dokter');
    }
}
