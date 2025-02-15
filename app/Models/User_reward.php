<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'points',
    ];

    /**
     * Mối quan hệ với bảng User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
