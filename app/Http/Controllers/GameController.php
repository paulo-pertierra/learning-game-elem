<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GameController extends Controller
{
    public function index() {

        if (Auth::user()->role === 'admin')
            return Inertia::render('Admin/Games');
        else
            return Inertia::render('Student/Games');
    
    }
}
