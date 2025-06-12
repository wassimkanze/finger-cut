<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class EmployeeProjectController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();
        $project = Project::whereHas('employees', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($id);

        $planningSlots = $project->planningSlots;

        return view('employee.project-show', compact('project', 'planningSlots'));
    }
} 