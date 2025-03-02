<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $dates = ['deleted_at'];
}
