<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateDoctorScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->session()->get('doctor_authenticated') === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'schedule' => ['required', 'array', 'size:7'],
            'schedule.*' => ['required', 'array'],
            'schedule.*.is_open' => ['required', 'boolean'],
            'schedule.*.start_time' => ['nullable', 'date_format:H:i'],
            'schedule.*.end_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $schedule = $this->input('schedule');

                if (! is_array($schedule) || $validator->errors()->isNotEmpty()) {
                    return;
                }

                $dayKeys = array_map('intval', array_keys($schedule));

                if (array_diff(range(1, 7), $dayKeys) !== []) {
                    $validator->errors()->add('schedule', 'Jadwal harus mencakup seluruh hari dalam seminggu.');

                    return;
                }

                foreach ($schedule as $day) {
                    if (! is_array($day) || ! filter_var($day['is_open'] ?? null, FILTER_VALIDATE_BOOLEAN)) {
                        continue;
                    }

                    $startTime = $day['start_time'] ?? null;
                    $endTime = $day['end_time'] ?? null;

                    if (! is_string($startTime) || ! is_string($endTime)) {
                        $validator->errors()->add('schedule', 'Jam mulai dan selesai wajib diisi untuk hari praktik.');

                        return;
                    }

                    if ($startTime >= $endTime) {
                        $validator->errors()->add('schedule', 'Jam selesai harus setelah jam mulai.');

                        return;
                    }
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'schedule.required' => 'Jadwal praktik wajib diisi.',
            'schedule.size' => 'Jadwal harus mencakup tujuh hari.',
            'schedule.*.is_open.required' => 'Status praktik setiap hari wajib ditentukan.',
            'schedule.*.start_time.date_format' => 'Format jam mulai tidak valid.',
            'schedule.*.end_time.date_format' => 'Format jam selesai tidak valid.',
        ];
    }
}
