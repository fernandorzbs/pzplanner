<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //==============================================================
    // ADMIN DASHBOARD
    //==============================================================
    public function dashboard()
    {
        $title = "Dashboard";
        $contactos = Contacto::count();

        return view('admin.dashboard.dashboard', compact('title', 'contactos'));
    }
}
