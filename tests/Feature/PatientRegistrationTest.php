<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Hash;
use PDOException;
use Tests\TestCase;

class PatientRegistrationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_valid_patient_registration_creates_account_and_redirects_to_login(): void
    {
        $this->withoutVite();

        $this->get(route('pasien.daftar'))
            ->assertOk()
            ->assertSee('action="'.route('pasien.register').'"', false);

        $response = $this->post(route('pasien.register'), [
            'name' => 'Nadia Putri',
            'birth_date' => '2000-04-12',
            'gender' => 'perempuan',
            'phone' => '0812 3456 7890',
            'nik' => '3201011234567890',
            'email' => 'nadia@example.com',
            'password' => 'LARASati1405',
            'password_confirmation' => 'LARASati1405',
            'terms' => '1',
        ]);

        $response->assertRedirect(route('pasien.daftar'))
            ->assertSessionHas('registration_success', true);

        $this->assertDatabaseHas('users', [
            'name' => 'Nadia Putri',
            'gender' => 'perempuan',
            'phone' => '0812 3456 7890',
            'nik' => '3201011234567890',
            'email' => 'nadia@example.com',
        ]);

        $user = User::query()->where('email', 'nadia@example.com')->firstOrFail();
        $this->assertSame('2000-04-12', $user->birth_date->toDateString());
        $this->assertTrue(Hash::check('LARASati1405', $user->password));

        $this->get(route('pasien.daftar'))
            ->assertOk()
            ->assertSee('Pendaftaran berhasil')
            ->assertSee('href="'.route('pasien.login').'"', false)
            ->assertSee('id="registration-success-dialog"', false);
    }

    public function test_patient_registration_shows_validation_errors_without_creating_an_account(): void
    {
        $this->withoutVite();

        $this->from(route('pasien.daftar'))
            ->followingRedirects()
            ->post(route('pasien.register'), [])
            ->assertOk()
            ->assertSee('Nama lengkap wajib diisi.')
            ->assertSee('Data tidak valid atau tidak lengkap, mohon isi dengan benar.')
            ->assertDontSee('Pendaftaran belum dapat diproses karena koneksi database bermasalah.');

        $this->assertDatabaseCount('users', 0);
    }

    public function test_patient_registration_database_failure_returns_to_form_and_reports_exception(): void
    {
        $this->withoutVite();
        Exceptions::fake();

        $shouldFailQuery = true;
        DB::connection()->beforeExecuting(function (string $query, array $bindings, Connection $connection) use (&$shouldFailQuery): void {
            if (! $shouldFailQuery) {
                return;
            }

            $shouldFailQuery = false;

            throw new QueryException(
                $connection->getName(),
                $query,
                $bindings,
                new PDOException('Database is unavailable.'),
            );
        });

        $this->from(route('pasien.daftar'))
            ->post(route('pasien.register'), [
                'name' => 'Nadia Putri',
                'birth_date' => '2000-04-12',
                'gender' => 'perempuan',
                'phone' => '0812 3456 7890',
                'nik' => '3201011234567890',
                'email' => 'nadia@example.com',
                'password' => 'ClinicOne123',
                'password_confirmation' => 'ClinicOne123',
                'terms' => '1',
            ])
            ->assertRedirect(route('pasien.daftar'))
            ->assertSessionHas('registration_error', 'Pendaftaran gagal diproses karena ada masalah pada server. Silakan coba kembali nanti.')
            ->assertSessionMissing('_old_input.password')
            ->assertSessionMissing('_old_input.password_confirmation');

        $this->get(route('pasien.daftar'))
            ->assertOk()
            ->assertSee('Pendaftaran gagal diproses karena ada masalah pada server. Silakan coba kembali nanti.')
            ->assertDontSee('Data tidak valid atau tidak lengkap, mohon isi dengan benar.');

        $this->assertDatabaseCount('users', 0);
        Exceptions::assertReported(QueryException::class);
    }

    public function test_patient_registration_form_uses_https_behind_railway_proxy(): void
    {
        $this->withoutVite();

        $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'clinicone-production.up.railway.app',
        ])
            ->get(route('pasien.daftar'))
            ->assertOk()
            ->assertSee('action="https://clinicone-production.up.railway.app/pasien/daftar"', false);
    }

    public function test_patient_registration_rejects_duplicate_email_and_nik(): void
    {
        $this->withoutVite();
        User::factory()->create([
            'email' => 'nadia@example.com',
            'nik' => '3201011234567890',
        ]);

        $this->from(route('pasien.daftar'))
            ->post(route('pasien.register'), [
                'name' => 'Nadia Putri',
                'birth_date' => '2000-04-12',
                'gender' => 'perempuan',
                'phone' => '0812 3456 7890',
                'nik' => '3201011234567890',
                'email' => 'nadia@example.com',
                'password' => 'ClinicOne123',
                'password_confirmation' => 'ClinicOne123',
                'terms' => '1',
            ])
            ->assertRedirect(route('pasien.daftar'))
            ->assertSessionHasErrors([
                'email' => 'Alamat email sudah terdaftar.',
                'nik' => 'NIK sudah terdaftar.',
            ]);

        $this->get(route('pasien.daftar'))
            ->assertOk()
            ->assertSee('id="terms" name="terms" type="checkbox" value="1" required checked', false);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_patient_registration_rejects_invalid_profile_and_unaccepted_terms(): void
    {
        $this->withoutVite();

        $this->from(route('pasien.daftar'))
            ->post(route('pasien.register'), [
                'name' => 'Nadia Putri',
                'birth_date' => now()->addDay()->toDateString(),
                'gender' => 'other',
                'phone' => 'not-a-phone',
                'nik' => '123',
                'email' => 'nadia@example.com',
                'password' => 'ClinicOne123',
                'password_confirmation' => 'ClinicOne123',
                'terms' => '0',
            ])
            ->assertRedirect(route('pasien.daftar'))
            ->assertSessionHasErrors([
                'birth_date' => 'Tanggal lahir harus sebelum hari ini.',
                'gender' => 'Jenis kelamin yang dipilih tidak valid.',
                'phone' => 'Format nomor ponsel tidak valid.',
                'nik' => 'NIK harus terdiri dari 16 angka.',
                'terms' => 'Anda harus menyetujui syarat dan kebijakan privasi.',
            ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_patient_registration_rejects_weak_or_unconfirmed_password(): void
    {
        $this->withoutVite();

        $this->from(route('pasien.daftar'))
            ->post(route('pasien.register'), [
                'name' => 'Nadia Putri',
                'birth_date' => '2000-04-12',
                'gender' => 'perempuan',
                'phone' => '0812 3456 7890',
                'nik' => '3201011234567890',
                'email' => 'nadia@example.com',
                'password' => 'ClinicOne123',
                'password_confirmation' => 'different',
                'terms' => '1',
            ])
            ->assertRedirect(route('pasien.daftar'))
            ->assertSessionHasErrors([
                'password' => 'Konfirmasi kata sandi tidak cocok.',
            ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function test_patient_registration_rejects_password_without_letters_and_numbers(): void
    {
        $this->withoutVite();

        $this->from(route('pasien.daftar'))
            ->post(route('pasien.register'), [
                'name' => 'Nadia Putri',
                'birth_date' => '2000-04-12',
                'gender' => 'perempuan',
                'phone' => '0812 3456 7890',
                'nik' => '3201011234567890',
                'email' => 'nadia@example.com',
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'terms' => '1',
            ])
            ->assertRedirect(route('pasien.daftar'))
            ->assertSessionHasErrors([
                'password' => 'Kata sandi harus mengandung huruf.',
            ]);

        $this->assertDatabaseCount('users', 0);
    }
}
