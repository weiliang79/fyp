<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentMenuController extends Controller
{
    public function index()
    {
        return view('menu.index');
    }
}
