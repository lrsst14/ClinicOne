<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'full_name',
        'title',
        'specialization',
        'str_number',
        'sip_number',
        'phone',
        'email',
        'bio',
        'photo_path',
    ];

    protected $hidden = ['access_code_hash'];
}
