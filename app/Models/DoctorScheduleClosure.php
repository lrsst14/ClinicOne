<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorScheduleClosure extends Model
{
    protected $fillable = ['closed_on'];

    protected function casts(): array
    {
        return [
            'closed_on' => 'date',
        ];
    }
}
