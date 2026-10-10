<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DoctorDashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_doctor_dashboard_displays_database_backed_summary_and_todays_appointments(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 9)->setTime(7, 30));
        $patient = User::factory()->create(['name' => 'Sinta Amelia']);

        Appointment::factory()->for($patient, 'patient')->create([
            'scheduled_at' => now()->setTime(8, 0),
            'status' => Appointment::STATUS_PENDING,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'scheduled_at' => now()->setTime(8, 30),
            'status' => Appointment::STATUS_CONFIRMED,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'scheduled_at' => now()->setTime(9, 0),
            'status' => Appointment::STATUS_COMPLETED,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'scheduled_at' => now()->setTime(9, 30),
            'status' => Appointment::STATUS_CANCELLED,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'scheduled_at' => now()->addDay()->setTime(8, 0),
            'status' => Appointment::STATUS_PENDING,
        ]);

        $response = $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.dashboard'));

        $response->assertOk()
            ->assertViewHas('appointmentCount', 3)
            ->assertViewHas('waitingAppointmentCount', 1)
            ->assertViewHas('completedAppointmentCount', 1)
            ->assertViewHas('availableSlotCount', 3)
            ->assertViewHas('appointments', fn ($appointments) => $appointments->count() === 4)
            ->assertSee('Sinta Amelia')
            ->assertSee('Dibatalkan')
            ->assertSee('Jumat, 9 Oktober 2026');
    }

    public function test_doctor_dashboard_requires_a_doctor_session(): void
    {
        $this->get(route('dokter.dashboard'))
            ->assertRedirect(route('dokter.login'));
    }

    public function test_doctor_dashboard_shows_no_appointments_and_no_slots_when_clinic_is_closed(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 11)->setTime(7, 30));

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.dashboard'))
            ->assertOk()
            ->assertViewHas('appointmentCount', 0)
            ->assertViewHas('availableSlotCount', 0)
            ->assertSee('Belum ada janji temu untuk hari ini.');
    }
}
