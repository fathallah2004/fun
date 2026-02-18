<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = session('authenticated_user');
        
        return view('dashboard', compact('user'));
    }
}
