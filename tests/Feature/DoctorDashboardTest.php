<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DoctorDashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_doctor_dashboard_displays_database_backed_summary_and_todays_appointments(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-09 07:30:00', Appointment::TIMEZONE));
        $patient = User::factory()->create(['name' => 'Sinta Amelia']);

        Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-09',
            'appointment_time' => '08:00',
            'status' => Appointment::STATUS_PENDING,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-09',
            'appointment_time' => '08:30',
            'status' => Appointment::STATUS_CONFIRMED,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-09',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_COMPLETED,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-09',
            'appointment_time' => '09:30',
            'status' => Appointment::STATUS_CANCELLED,
        ]);
        Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-10',
            'appointment_time' => '08:00',
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
            ->assertViewHas('appointments', fn ($appointments) => $appointments->count() === 5)
            ->assertSee('Sinta Amelia')
            ->assertSee('Dibatalkan')
            ->assertSee('10 Okt 2026')
            ->assertSee('Jumat, 9 Oktober 2026');
    }

    public function test_doctor_dashboard_requires_a_doctor_session(): void
    {
        $this->get(route('dokter.dashboard'))
            ->assertRedirect(route('dokter.login'));
    }

    public function test_doctor_dashboard_displays_future_appointments(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-09 07:30:00', Appointment::TIMEZONE));
        $patient = User::factory()->create(['name' => 'Nadia Putri']);
        Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_PENDING,
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.dashboard'))
            ->assertOk()
            ->assertSee('Nadia Putri')
            ->assertSee('12 Okt 2026')
            ->assertViewHas('appointmentCount', 0)
            ->assertViewHas('appointments', fn ($appointments) => $appointments->count() === 1);
    }

    public function test_doctor_dashboard_shows_no_appointments_and_no_slots_when_clinic_is_closed(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-11 07:30:00', Appointment::TIMEZONE));

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.dashboard'))
            ->assertOk()
            ->assertViewHas('appointmentCount', 0)
            ->assertViewHas('availableSlotCount', 0)
            ->assertSee('Belum ada janji temu mendatang.');
    }
}
