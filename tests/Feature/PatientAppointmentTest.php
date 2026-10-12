<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\DoctorWeeklySchedule;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PatientAppointmentTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_patient_login_from_appointment_page(): void
    {
        $this->get(route('pasien.pendaftaran'))
            ->assertRedirect(route('pasien.login'));
    }

    public function test_patient_can_request_an_available_appointment(): void
    {
        $appointmentDate = $this->nextOpenPracticeDate(1);
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->post(route('pasien.janji.store'), [
                'appointment_date' => $appointmentDate,
                'appointment_time' => '09:00',
                'complaint' => 'Demam dan pusing.',
            ])
            ->assertRedirect(route('pasien.pendaftaran', ['date' => $appointmentDate]))
            ->assertSessionHas('appointment_success');

        $appointment = $patient->appointments()->firstOrFail();
        $this->assertSame($appointmentDate, $appointment->appointment_date->toDateString());
        $this->assertSame('09:00', substr($appointment->appointment_time, 0, 5));
        $this->assertSame('Demam dan pusing.', $appointment->complaint);
        $this->assertSame(Appointment::STATUS_PENDING, $appointment->status);
        $this->assertDatabaseHas('appointment_slot_reservations', [
            'appointment_date' => $appointmentDate,
            'appointment_time' => '09:00',
        ]);

        $this->get(route('pasien.pendaftaran'))
            ->assertOk()
            ->assertSee('Janji saya')
            ->assertSee('Demam dan pusing.');
    }

    public function test_patient_cannot_book_outside_the_weekly_schedule_or_a_taken_slot(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->from(route('pasien.pendaftaran'))
            ->post(route('pasien.janji.store'), [
                'appointment_date' => '2026-10-11',
                'appointment_time' => '09:00',
                'complaint' => 'Kontrol rutin.',
            ])
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHasErrors('appointment_time');

        $this->assertDatabaseCount('appointments', 0);

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => '2026-10-16',
            'appointment_time' => '11:00',
            'complaint' => 'Kontrol rutin.',
        ])
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHasErrors('appointment_time');

        $this->assertDatabaseCount('appointments', 0);
    }

    public function test_patient_cannot_book_a_slot_reserved_by_another_patient(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $existingPatient = User::factory()->create();
        $requestingPatient = User::factory()->create();
        $appointment = Appointment::factory()->create([
            'user_id' => $existingPatient->id,
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

        $this->actingAs($requestingPatient)
            ->from(route('pasien.pendaftaran'))
            ->post(route('pasien.janji.store'), [
                'appointment_date' => '2026-10-12',
                'appointment_time' => '09:00',
                'complaint' => 'Kontrol rutin.',
            ])
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHasErrors([
                'appointment_time' => 'Slot jadwal tidak tersedia. Silakan pilih waktu lain.',
            ]);

        $this->assertDatabaseCount('appointments', 1);
        $this->assertDatabaseCount('appointment_slot_reservations', 1);
        $this->assertDatabaseHas('appointment_slot_reservations', [
            'appointment_id' => $appointment->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
        ]);
    }

    public function test_patient_cannot_book_a_slot_reserved_after_availability_check(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $existingPatient = User::factory()->create();
        $requestingPatient = User::factory()->create();
        $reservationAddedAfterAvailabilityCheck = false;

        DB::listen(function (QueryExecuted $query) use ($existingPatient, &$reservationAddedAfterAvailabilityCheck): void {
            $sql = strtolower(ltrim($query->sql));

            if (
                $reservationAddedAfterAvailabilityCheck
                || ! str_starts_with($sql, 'select')
                || ! str_contains($sql, 'appointment_slot_reservations')
            ) {
                return;
            }

            $reservationAddedAfterAvailabilityCheck = true;
            $appointment = Appointment::factory()->create([
                'user_id' => $existingPatient->id,
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
        });

        $response = $this->actingAs($requestingPatient)
            ->from(route('pasien.pendaftaran'))
            ->post(route('pasien.janji.store'), [
                'appointment_date' => '2026-10-12',
                'appointment_time' => '09:00',
                'complaint' => 'Kontrol rutin.',
            ]);

        $response
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHasErrors([
                'appointment_time' => 'Slot jadwal tidak tersedia. Silakan pilih waktu lain.',
            ]);

        $this->assertTrue($reservationAddedAfterAvailabilityCheck);
        $this->assertDatabaseCount('appointments', 1);
        $this->assertDatabaseCount('appointment_slot_reservations', 1);
        $this->assertDatabaseHas('appointment_slot_reservations', [
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
        ]);
    }

    public function test_patient_cannot_book_a_slot_that_expires_after_form_validation(): void
    {
        $this->travelTo(CarbonImmutable::parse('2000-01-03 00:00:00', 'UTC'));
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->from(route('pasien.pendaftaran'))
            ->post(route('pasien.janji.store'), [
                'appointment_date' => '2000-01-03',
                'appointment_time' => '08:00',
                'complaint' => 'Kontrol rutin.',
            ])
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHasErrors([
                'appointment_time' => 'Slot jadwal tidak tersedia. Silakan pilih waktu lain.',
            ]);

        $this->assertDatabaseCount('appointments', 0);
        $this->assertDatabaseCount('appointment_slot_reservations', 0);
    }

    public function test_patient_appointment_dates_follow_jakarta_day_when_utc_date_is_previous_day(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-11 17:30:00', 'UTC'));
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->get(route('pasien.pendaftaran'))
            ->assertOk()
            ->assertSee('min="2026-10-12"', false);

        $this->get(route('pasien.pendaftaran', ['date' => '2026-10-11']))
            ->assertRedirect()
            ->assertSessionHasErrors('date');

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => '2026-10-11',
            'appointment_time' => '09:00',
            'complaint' => 'Kontrol rutin.',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('appointment_date');

        $this->assertDatabaseCount('appointments', 0);
    }

    public function test_patient_cannot_book_a_past_or_current_slot_but_can_book_a_future_slot_in_jakarta_time(): void
    {
        $appointmentDate = $this->nextOpenPracticeDate(1);
        $this->travelTo(CarbonImmutable::parse($appointmentDate.' 08:00', Appointment::TIMEZONE));
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->post(route('pasien.janji.store'), [
                'appointment_date' => $appointmentDate,
                'appointment_time' => '07:30',
                'complaint' => 'Kontrol rutin.',
            ])
            ->assertRedirect()
            ->assertSessionHasErrors('appointment_time');

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => $appointmentDate,
            'appointment_time' => '08:00',
            'complaint' => 'Kontrol rutin.',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('appointment_time');

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => $appointmentDate,
            'appointment_time' => '08:30',
            'complaint' => 'Kontrol rutin.',
        ])
            ->assertRedirect(route('pasien.pendaftaran', ['date' => $appointmentDate]))
            ->assertSessionHas('appointment_success');

        $appointment = Appointment::query()->firstOrFail();
        $this->assertSame($appointmentDate, $appointment->appointment_date->toDateString());
        $this->assertSame('08:30', substr($appointment->appointment_time, 0, 5));
    }

    public function test_patient_can_book_last_practice_slots_but_not_the_closing_time(): void
    {
        $fridayDate = $this->nextOpenPracticeDate(5);
        $mondayDate = CarbonImmutable::parse($fridayDate, Appointment::TIMEZONE)
            ->addDays(3)
            ->toDateString();
        $patient = User::factory()->create();

        $this->actingAs($patient)
            ->post(route('pasien.janji.store'), [
                'appointment_date' => $fridayDate,
                'appointment_time' => '10:30',
                'complaint' => 'Kontrol rutin.',
            ])
            ->assertSessionHas('appointment_success');

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => $fridayDate,
            'appointment_time' => '11:00',
            'complaint' => 'Kontrol rutin.',
        ])->assertSessionHasErrors('appointment_time');

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => $mondayDate,
            'appointment_time' => '11:30',
            'complaint' => 'Kontrol rutin.',
        ])->assertSessionHas('appointment_success');

        $this->post(route('pasien.janji.store'), [
            'appointment_date' => $mondayDate,
            'appointment_time' => '12:00',
            'complaint' => 'Kontrol rutin.',
        ])->assertSessionHasErrors('appointment_time');

        $this->assertDatabaseCount('appointments', 2);
    }

    public function test_patient_can_only_cancel_their_own_appointment_and_cancelled_slot_can_be_booked_again(): void
    {
        $appointmentDate = $this->nextOpenPracticeDate(1);
        $patient = User::factory()->create();
        $anotherPatient = User::factory()->create();

        $this->actingAs($patient)->post(route('pasien.janji.store'), [
            'appointment_date' => $appointmentDate,
            'appointment_time' => '09:00',
            'complaint' => 'Kontrol.',
        ]);

        $appointment = Appointment::query()->firstOrFail();

        $this->actingAs($anotherPatient)
            ->delete(route('pasien.janji.cancel', $appointment))
            ->assertNotFound();

        $this->assertSame(Appointment::STATUS_PENDING, $appointment->fresh()->status);
        $this->assertDatabaseHas('appointment_slot_reservations', [
            'appointment_id' => $appointment->id,
            'appointment_date' => $appointmentDate,
            'appointment_time' => '09:00',
        ]);

        $this->actingAs($patient)
            ->delete(route('pasien.janji.cancel', $appointment))
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHas('appointment_success');

        $this->assertSame(Appointment::STATUS_CANCELLED, $appointment->fresh()->status);
        $this->assertDatabaseCount('appointment_slot_reservations', 0);

        $this->actingAs($anotherPatient)
            ->post(route('pasien.janji.store'), [
                'appointment_date' => $appointmentDate,
                'appointment_time' => '09:00',
                'complaint' => 'Janji baru.',
            ])
            ->assertSessionHas('appointment_success');

        $this->assertDatabaseCount('appointments', 2);
        $this->assertDatabaseCount('appointment_slot_reservations', 1);
    }

    public function test_patient_can_cancel_a_confirmed_appointment_and_release_its_reservation(): void
    {
        $patient = User::factory()->create();
        $appointment = Appointment::factory()->create([
            'user_id' => $patient->id,
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

        $this->actingAs($patient)
            ->delete(route('pasien.janji.cancel', $appointment))
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHas('appointment_success');

        $this->assertSame(Appointment::STATUS_CANCELLED, $appointment->fresh()->status);
        $this->assertDatabaseMissing('appointment_slot_reservations', [
            'appointment_id' => $appointment->id,
        ]);
    }

    public function test_patient_cannot_cancel_an_appointment_with_a_terminal_status(): void
    {
        $patient = User::factory()->create();
        $appointment = Appointment::factory()->create([
            'user_id' => $patient->id,
            'status' => Appointment::STATUS_REJECTED,
        ]);

        $this->actingAs($patient)
            ->from(route('pasien.pendaftaran'))
            ->delete(route('pasien.janji.cancel', $appointment))
            ->assertRedirect(route('pasien.pendaftaran'))
            ->assertSessionHasErrors([
                'appointment' => 'Janji ini sudah tidak dapat dibatalkan.',
            ]);

        $this->assertSame(Appointment::STATUS_REJECTED, $appointment->fresh()->status);
        $this->assertDatabaseMissing('appointment_slot_reservations', [
            'appointment_id' => $appointment->id,
        ]);
    }

    public function test_patient_dashboard_displays_the_saved_doctor_and_their_own_appointment_data(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $patient = User::factory()->create(['name' => 'Rani Wijaya']);
        $anotherPatient = User::factory()->create();
        DoctorProfile::query()->create([
            'full_name' => 'Dimas Pratama',
            'title' => 'dr.',
            'specialization' => 'Dokter Umum',
            'bio' => 'Melayani konsultasi kesehatan.',
        ]);
        Appointment::factory()->create([
            'user_id' => $patient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'complaint' => 'Keluhan pasien saat ini.',
            'status' => Appointment::STATUS_PENDING,
        ]);
        Appointment::factory()->create([
            'user_id' => $anotherPatient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:30',
            'complaint' => 'Keluhan milik akun lain.',
            'status' => Appointment::STATUS_PENDING,
        ]);

        $this->actingAs($patient)
            ->get(route('pasien.dashboard'))
            ->assertOk()
            ->assertSee('Rani Wijaya')
            ->assertSee('dr. Dimas Pratama')
            ->assertSee('Dokter Umum')
            ->assertSee('Keluhan pasien saat ini.')
            ->assertDontSee('Keluhan milik akun lain.')
            ->assertDontSee('dr. Andi');
    }

    public function test_patient_schedule_uses_saved_weekly_schedule_and_reservations(): void
    {
        $this->travelTo('2026-10-10 07:00:00');
        $patient = User::factory()->create();
        $mondaySchedule = DoctorWeeklySchedule::query()
            ->where('day_of_week', 1)
            ->firstOrFail();
        $mondaySchedule->update([
            'is_open' => true,
            'start_time' => '09:00',
            'end_time' => '11:00',
        ]);
        $appointment = Appointment::factory()->create([
            'user_id' => $patient->id,
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'complaint' => 'Kontrol sesuai jadwal.',
            'status' => Appointment::STATUS_PENDING,
        ]);
        DB::table('appointment_slot_reservations')->insert([
            'appointment_date' => '2026-10-12',
            'appointment_time' => '09:00',
            'appointment_id' => $appointment->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($patient)
            ->get(route('pasien.jadwal'))
            ->assertOk()
            ->assertSee('"start_time":"09:00"', false)
            ->assertSee('"2026-10-12":["09:00"]', false)
            ->assertSee('"2026-10-12|09:00":true', false)
            ->assertSee('Kontrol sesuai jadwal.')
            ->assertDontSee('2026-10-09', false);
    }

    public function test_patient_history_displays_only_saved_appointment_and_identity_details(): void
    {
        $patient = User::factory()->create([
            'name' => 'Rani Wijaya',
            'gender' => 'Perempuan',
            'birth_date' => '1998-05-12',
        ]);
        $anotherPatient = User::factory()->create(['name' => 'Dewi Lestari']);
        Appointment::factory()->create([
            'user_id' => $patient->id,
            'appointment_date' => '2026-10-09',
            'appointment_time' => '09:00',
            'complaint' => 'Keluhan yang tersimpan.',
            'status' => Appointment::STATUS_COMPLETED,
        ]);
        Appointment::factory()->create([
            'user_id' => $anotherPatient->id,
            'appointment_date' => '2026-10-09',
            'appointment_time' => '09:30',
            'complaint' => 'Keluhan akun lain.',
            'status' => Appointment::STATUS_COMPLETED,
        ]);

        $this->actingAs($patient)
            ->get(route('pasien.riwayat'))
            ->assertOk()
            ->assertSee('Rani Wijaya')
            ->assertSee('ID akun')
            ->assertSee((string) $patient->id)
            ->assertSee('Perempuan')
            ->assertSee('12 Mei 1998')
            ->assertSee('Keluhan yang tersimpan.')
            ->assertDontSee('Keluhan akun lain.')
            ->assertDontSee('Dewi Lestari')
            ->assertDontSee('Nadia Putri')
            ->assertDontSee('118/78')
            ->assertDontSee('RM-260924-003');
    }

    public function test_patient_appointment_page_displays_only_the_signed_in_patients_records(): void
    {
        $patient = User::factory()->create();
        $anotherPatient = User::factory()->create();
        Appointment::factory()->create([
            'user_id' => $patient->id,
            'complaint' => 'Keluhan milik pasien.',
        ]);
        Appointment::factory()->create([
            'user_id' => $anotherPatient->id,
            'complaint' => 'Keluhan milik pasien lain.',
        ]);

        $this->actingAs($patient)
            ->get(route('pasien.pendaftaran'))
            ->assertOk()
            ->assertSee('Keluhan milik pasien.')
            ->assertDontSee('Keluhan milik pasien lain.');
    }

    private function nextOpenPracticeDate(int $dayOfWeek): string
    {
        DoctorWeeklySchedule::query()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_open', true)
            ->firstOrFail();

        $date = CarbonImmutable::today(Appointment::TIMEZONE)->addDay();

        while ($date->dayOfWeekIso !== $dayOfWeek) {
            $date = $date->addDay();
        }

        return $date->toDateString();
    }
}
