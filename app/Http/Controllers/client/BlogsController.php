<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //
        return view('blogs.index');
    }
    public function details(Request $request)
    {
        //
        //
        return view('blogs.details');
    }
}
