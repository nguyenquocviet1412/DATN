<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_post',
        'note',
        'is_hidden',

    ];
    //Liên kết với bảng post
    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
    //Liên kết với bảng user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

