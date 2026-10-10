<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePatientAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:'.CarbonImmutable::today(Appointment::TIMEZONE)->toDateString(),
            ],
            'appointment_time' => ['required', 'date_format:H:i'],
            'complaint' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'appointment_date.required' => 'Tanggal janji wajib dipilih.',
            'appointment_date.date_format' => 'Format tanggal janji tidak valid.',
            'appointment_date.after_or_equal' => 'Tanggal janji tidak boleh di masa lalu.',
            'appointment_time.required' => 'Waktu janji wajib dipilih.',
            'appointment_time.date_format' => 'Format waktu janji tidak valid.',
            'complaint.required' => 'Keluhan atau tujuan kunjungan wajib diisi.',
            'complaint.max' => 'Keluhan maksimal 1.000 karakter.',
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny(['appointment_date', 'appointment_time'])) {
                    return;
                }

                $date = $this->string('appointment_date')->toString();
                $time = $this->string('appointment_time')->toString();

                if (! in_array($time, Appointment::availableTimesFor($date), true)) {
                    $validator->errors()->add('appointment_time', 'Slot jadwal tidak tersedia. Silakan pilih waktu lain.');
                }
            },
        ];
    }
}
