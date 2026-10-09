<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PatientLoginTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_patient_login_form_posts_to_the_login_endpoint(): void
    {
        $this->withoutVite();

        $this->get(route('pasien.login'))
            ->assertOk()
            ->assertSee('action="'.route('pasien.login.submit').'"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false);
    }

    public function test_patient_can_login_with_registered_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'patient@example.com',
            'password' => 'ClinicOne123',
        ]);

        $this->post(route('pasien.login.submit'), [
            'email' => 'patient@example.com',
            'password' => 'ClinicOne123',
        ])
            ->assertRedirect(route('pasien.dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('pasien.dashboard'))->assertOk();
    }

    public function test_patient_can_remain_logged_in_when_remember_me_is_selected(): void
    {
        $user = User::factory()->create([
            'email' => 'patient@example.com',
            'password' => 'ClinicOne123',
            'remember_token' => null,
        ]);

        $this->post(route('pasien.login.submit'), [
            'email' => 'patient@example.com',
            'password' => 'ClinicOne123',
            'remember' => '1',
        ])->assertRedirect(route('pasien.dashboard'));

        $this->assertNotNull($user->fresh()->getRememberToken());
    }

    public function test_patient_login_rejects_invalid_credentials_with_a_generic_message(): void
    {
        User::factory()->create([
            'email' => 'patient@example.com',
            'password' => 'ClinicOne123',
        ]);

        $this->from(route('pasien.login'))
            ->followingRedirects()
            ->post(route('pasien.login.submit'), [
                'email' => 'patient@example.com',
                'password' => 'incorrect-password',
            ])
            ->assertOk()
            ->assertSee('Email atau kata sandi tidak valid.');

        $this->assertGuest();
    }

    public function test_patient_login_requires_email_and_password(): void
    {
        $this->from(route('pasien.login'))
            ->post(route('pasien.login.submit'), [])
            ->assertRedirect(route('pasien.login'))
            ->assertSessionHasErrors([
                'email' => 'Alamat email wajib diisi.',
                'password' => 'Kata sandi wajib diisi.',
            ]);

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_from_patient_pages(): void
    {
        $this->get(route('pasien.dashboard'))
            ->assertRedirect(route('pasien.login'));
    }

    public function test_authenticated_patient_can_logout_and_ends_the_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('pasien.logout'))
            ->assertRedirect(route('pasien.login'));

        $this->assertGuest();

        $this->get(route('pasien.dashboard'))
            ->assertRedirect(route('pasien.login'));
    }

    public function test_authenticated_patient_is_redirected_from_the_login_form(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('pasien.login'))
            ->assertRedirect(route('pasien.dashboard'));
    }
}
