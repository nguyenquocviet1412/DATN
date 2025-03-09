<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['id_employee', 'action', 'ip_address', 'details'];

    // Liên kết với Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee');
    }
}
