<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = Project::with('employees')->get();
        $assignedProjectsCount = $user->projects->count();
        $totalProjectsCount = $projects->count();
        $users = User::where('id', '!=', $user->id)->get();

        return view('employee.dashboard', compact('projects', 'assignedProjectsCount', 'totalProjectsCount', 'users'));
    }

    public function projects(Request $request)
    {
        $user = Auth::user();

        if ($request->filter === 'assigned') {
            $projects = Project::whereHas('employees', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $projects = Project::all();
        }

        return view('employee.projects', compact('projects'));
    }

    public function users()
    {
        $users = \App\Models\User::all();
        return view('employee.users', compact('users'));
    }
} 