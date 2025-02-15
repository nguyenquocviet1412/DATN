<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'role',
        'fullname',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'position',
        'salary',
        'status'
    ];
}
