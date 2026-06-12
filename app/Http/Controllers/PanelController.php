<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function dashboard()
    {
        return view('panel.dashboard', ['page' => '']);
    }

    public function courses()
    {
        return view('panel.dashboard', ['page' => 'courses']);
    }

    public function students()
    {
        return view('panel.dashboard', ['page' => 'students']);
    }

    public function assignments()
    {
        return view('panel.dashboard', ['page' => 'assignments']);
    }

    public function settings()
    {
        return view('panel.dashboard', ['page' => 'settings']);
    }
}
