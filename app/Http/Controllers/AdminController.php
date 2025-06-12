<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Job;
use App\Models\PlanningSlot;

class AdminController extends Controller
{
    public function index()
    {
        $activeJobsCount = Job::where('is_active', true)->count();

        $data = [
            'users_count' => User::count(),
            'projects_count' => Project::count(),
            'jobs_count' => $activeJobsCount,
            'planning_count' => PlanningSlot::count(),
        ];

        return view('admin.dashboard', $data);
    }
} 