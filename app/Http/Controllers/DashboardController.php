<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    //

    public function dashboardView()
    {
        $user = Auth::guard('users')->user();
         return view('dashboard', ['user' => $user]);
    }
}
