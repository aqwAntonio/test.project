<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function welcome()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->hasRole('Admin')) {
                return redirect()->route('tasks.index');
            } elseif ($user->hasRole('Client')) {
                return redirect()->route('tasks.create');
            } else {
                return view('welcome');
            }
        }
    }

    public function index()
    {
        return redirect()->route('login');
    }

}
