<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRegistrationRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class PatientRegistrationController extends Controller
{
    public function __invoke(StorePatientRegistrationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'birth_date' => $validated['birth_date'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'nik' => $validated['nik'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return to_route('pasien.daftar')
            ->with('registration_success', true);
    }
}
