<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\DoctorScheduleClosure;
use App\Models\DoctorWeeklySchedule;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DoctorDashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_doctor_dashboard_displays_database_backed_summary_and_todays_appointments(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-09 07:30:00', Appointment::TIMEZONE));
        $patient = User::factory()->create(['name' => 'Sinta Amelia']);

        $pendingAppointment = Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-09',
            'appointment_time' => '08:00',
            'status' => Appointment::STATUS_PENDING,
        ]);
        $confirmedAppointment = Appointment::factory()->for($patient, 'patient')->create([
            'appointment_date' => '2026-10-09',
            'appointment_time' => '08:30',
            'status' => Appointment::STATUS_CONFIRMED,
        ]);
        DB::table('appointment_slot_reservations')->insert([
            [
                'appointment_date' => '2026-10-09',
                'appointment_time' => '08:00',
                'appointment_id' => $pendingAppointment->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'appointment_date' => '2026-10-09',
                'appointment_time' => '08:30',
                'appointment_id' => $confirmedAppointment->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
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
            ->assertViewHas('availableSlotCount', 4)
            ->assertViewHas('appointments', fn ($appointments) => $appointments->count() === 5)
            ->assertSee('Sinta Amelia')
            ->assertSee('Dibatalkan')
            ->assertSee('10 Okt 2026')
            ->assertSee('Jumat, 9 Oktober 2026')
            ->assertDontSee('<span class="font-medium">Jumat, 9 Oktober 2026</span>', false);
    }

    public function test_doctor_dashboard_requires_a_doctor_session(): void
    {
        $this->get(route('dokter.dashboard'))
            ->assertRedirect(route('dokter.login'));
    }

    public function test_doctor_dashboard_header_displays_the_saved_doctor_profile(): void
    {
        DoctorProfile::query()->create([
            'full_name' => 'Maya Pratama',
            'title' => 'dr.',
            'specialization' => 'Dokter Anak',
            'photo_path' => 'doctor-profile/maya.jpg',
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.dashboard'))
            ->assertOk()
            ->assertSee('Selamat pagi, dr. Maya Pratama')
            ->assertSee('dr. Maya Pratama')
            ->assertSee('Dokter Anak')
            ->assertSee('src="'.route('dokter.profil.photo').'"', false)
            ->assertDontSee('dr. Andi')
            ->assertDontSee('Doctor_portrait.png');
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
            ->assertSee('Belum ada janji temu mendatang.')
            ->assertSee('Klinik tutup hari ini')
            ->assertSee('Tidak ada jadwal praktik hari ini')
            ->assertDontSee('Klinik siap melayani');
    }

    public function test_doctor_dashboard_sidebar_shows_today_closure_and_saved_practice_hours(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-12 07:30:00', Appointment::TIMEZONE));
        DoctorWeeklySchedule::query()
            ->where('day_of_week', 1)
            ->update([
                'start_time' => '09:00',
                'end_time' => '13:00',
            ]);
        DoctorScheduleClosure::query()->create([
            'closed_on' => '2026-10-12',
        ]);

        $this->withoutVite()
            ->withSession(['doctor_authenticated' => true])
            ->get(route('dokter.dashboard'))
            ->assertOk()
            ->assertSee('Klinik tutup hari ini')
            ->assertSee('Jam praktik 09:00 – 13:00')
            ->assertDontSee('Klinik siap melayani')
            ->assertDontSee('Jam praktik 08.00 – 12.00');
    }
}
