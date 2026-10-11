<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DoctorAppointmentTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_doctor_must_be_authenticated_to_manage_appointments(): void
    {
        $appointment = Appointment::factory()->create();

        $this->get(route('dokter.janji'))
            ->assertRedirect(route('dokter.login'));

        $this->patch(route('dokter.janji.status', $appointment), [
            'status' => Appointment::STATUS_CONFIRMED,
        ])->assertForbidden();
    }

    public function test_authenticated_doctor_can_filter_and_view_real_patient_appointments(): void
    {
        $this->withoutVite();
        $patient = User::factory()->create(['name' => 'Nadia Putri']);
        $otherPatient = User::factory()->create(['name' => 'Budi Santoso']);
        Appointment::factory()->create([
            'user_id' => $patient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'complaint' => 'Keluhan Nadia.',
        ]);
        Appointment::factory()->create([
            'user_id' => $otherPatient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:30',
            'complaint' => 'Keluhan Budi.',
        ]);

        $this->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.janji', ['search' => 'Nadia', 'status' => 'pending']))
            ->assertOk()
            ->assertSee('Kelola Janji')
            ->assertSee('Nadia Putri')
            ->assertSee('Keluhan Nadia.')
            ->assertSee('Terima')
            ->assertSee('Tolak')
            ->assertDontSee('Budi Santoso')
            ->assertDontSee('Keluhan Budi.')
            ->assertSee('data-appointment-details', false)
            ->assertSee('appointment-detail-modal', false)
            ->assertSee('aria-label="Tutup detail janji"', false)
            ->assertSee('M6 18 18 6M6 6l12 12', false)
            ->assertSee('Detail Janji');
    }

    public function test_appointment_page_displays_the_saved_doctor_profile(): void
    {
        DoctorProfile::query()->create([
            'full_name' => 'Maya Pratama',
            'title' => 'dr.',
            'specialization' => 'Dokter Anak',
            'photo_path' => 'doctor-profile/maya.jpg',
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.janji'))
            ->assertOk()
            ->assertSee('dr. Maya Pratama')
            ->assertSee('Dokter Anak')
            ->assertSee(route('dokter.profil.photo'), false)
            ->assertDontSee('dr. Andi');
    }

    public function test_doctor_can_confirm_or_reject_pending_appointments(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $appointment = Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_PENDING,
        ]);
        DB::table('appointment_slot_reservations')->insert([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'appointment_id' => $appointment->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withSession(['doctor_authenticated' => true])
            ->patch(route('dokter.janji.status', $appointment), [
                'status' => Appointment::STATUS_CONFIRMED,
            ])
            ->assertRedirect(route('dokter.janji'))
            ->assertSessionHas('appointment_success');

        $this->assertSame(Appointment::STATUS_CONFIRMED, $appointment->fresh()->status);
        $this->assertDatabaseCount('appointment_slot_reservations', 1);

        $this->patch(route('dokter.janji.status', $appointment), [
            'status' => Appointment::STATUS_REJECTED,
        ])->assertSessionHasErrors('status');

        $this->assertSame(Appointment::STATUS_CONFIRMED, $appointment->fresh()->status);
        $this->assertDatabaseHas('appointment_slot_reservations', [
            'appointment_id' => $appointment->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
        ]);
    }

    public function test_rejecting_an_appointment_releases_its_reserved_slot(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $appointment = Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
        ]);
        DB::table('appointment_slot_reservations')->insert([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'appointment_id' => $appointment->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withSession(['doctor_authenticated' => true])
            ->patch(route('dokter.janji.status', $appointment), [
                'status' => Appointment::STATUS_REJECTED,
            ])
            ->assertRedirect(route('dokter.janji'));

        $this->assertSame(Appointment::STATUS_REJECTED, $appointment->fresh()->status);
        $this->assertDatabaseCount('appointment_slot_reservations', 0);
    }

    public function test_doctor_can_mark_a_past_confirmed_appointment_complete(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-12 02:30:00', 'UTC'));
        $appointment = Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_CONFIRMED,
        ]);
        DB::table('appointment_slot_reservations')->insert([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'appointment_id' => $appointment->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.janji'))
            ->assertOk()
            ->assertSee('Tandai selesai');

        $this->patch(route('dokter.janji.status', $appointment), [
            'status' => Appointment::STATUS_COMPLETED,
        ])
            ->assertRedirect(route('dokter.janji'));

        $this->assertSame(Appointment::STATUS_COMPLETED, $appointment->fresh()->status);
        $this->assertDatabaseMissing('appointment_slot_reservations', [
            'appointment_id' => $appointment->id,
        ]);
    }

    public function test_doctor_can_mark_an_appointment_complete_at_its_jakarta_start_time(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-12 02:00:00', 'UTC'));
        $appointment = Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_CONFIRMED,
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.janji'))
            ->assertOk()
            ->assertSee('Tandai selesai');

        $this->patch(route('dokter.janji.status', $appointment), [
            'status' => Appointment::STATUS_COMPLETED,
        ])
            ->assertRedirect(route('dokter.janji'));

        $this->assertSame(Appointment::STATUS_COMPLETED, $appointment->fresh()->status);
    }

    public function test_doctor_cannot_mark_an_appointment_complete_before_its_jakarta_start_time(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-12 01:59:59', 'UTC'));
        $appointment = Appointment::factory()->create([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'status' => Appointment::STATUS_CONFIRMED,
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.janji'))
            ->assertOk()
            ->assertDontSee('Tandai selesai');

        $this->patch(route('dokter.janji.status', $appointment), [
            'status' => Appointment::STATUS_COMPLETED,
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('status');

        $this->assertSame(Appointment::STATUS_CONFIRMED, $appointment->fresh()->status);
    }
}
