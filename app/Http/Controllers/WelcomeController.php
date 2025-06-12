<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class WelcomeController extends Controller
{
    public function index()
    {
        $jobs = Job::where('is_active', true)->get();
        return view('welcome', compact('jobs'));
    }
} 