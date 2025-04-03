<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
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
        'status'
    ];
    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    protected $dates = ['deleted_at'];
    // App\Models\Employee.php
public function logs()
{
    return $this->hasMany(Log::class, 'id_employee');
}
}
