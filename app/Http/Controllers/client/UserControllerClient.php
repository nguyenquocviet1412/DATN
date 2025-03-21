<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserControllerClient extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('home.UserProfile', compact('user'));
    }
}