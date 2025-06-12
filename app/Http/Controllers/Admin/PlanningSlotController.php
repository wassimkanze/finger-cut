<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanningSlot;
use App\Models\Project;

class PlanningSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planningSlots = PlanningSlot::with('project')->get();
        return view('admin.planning.index', compact('planningSlots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('admin.planning.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        PlanningSlot::create($validated);

        return redirect()->route('admin.planning.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PlanningSlot $planningSlot)
    {
        return view('admin.planning.show', compact('planningSlot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlanningSlot $planning)
    {
        $projects = Project::all();
        return view('admin.planning.edit', compact('planning', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlanningSlot $planning)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        $planning->update($validated);

        return redirect()->route('admin.planning.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlanningSlot $planning)
    {
        $planning->delete();

        return redirect()->route('admin.planning.index');
    }
}
