<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_employee',
        'title',
        'content',
        'image',
        'status',
    ];

    /**
     * Quan hệ với bảng Employee (Nhân viên viết bài)
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_employee');
    }
}
