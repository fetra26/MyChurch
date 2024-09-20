<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirect(){
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole(User::ROLE_ADMIN)) {
            return view('admin.dashboard');
        }elseif ($currentUser->hasRole(User::ROLE_SUPER_ADMIN)) {
            return view('super-admin.dashboard');
        }elseif ($currentUser->hasRole(User::ROLE_USER)) {
            return view('dashboard');
        }
    }
}
