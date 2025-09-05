<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $upcomingEvents = $user->upcomingEvents()->limit(5)->get();
        $recentEvents = $user->events()
            ->where('start_date', '<', now()->toDateString())
            ->orderBy('start_date', 'desc')
            ->limit(3)
            ->get();
        
        $stats = [
            'total_events' => $user->events()->count(),
            'upcoming_events' => $user->upcomingEvents()->count(),
            'completed_events' => $user->events()->where('status', 'completed')->count(),
        ];
        
        return view('employee.dashboard', compact('user', 'upcomingEvents', 'recentEvents', 'stats'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('employee.profile', compact('user'));
    }

    public function planning()
    {
        $user = auth()->user();
        $events = $user->events()->orderBy('start_date')->get();
        
        // Prepare events data for FullCalendar
        $calendarEvents = $events->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->format('Y-m-d') . ($event->start_time ? 'T' . $event->start_time->format('H:i:s') : ''),
                'end' => $event->end_date->format('Y-m-d') . ($event->end_time ? 'T' . $event->end_time->format('H:i:s') : ''),
                'color' => $event->color,
                'extendedProps' => [
                    'description' => $event->description,
                    'location' => $event->getFormattedAddress(),
                    'status' => $event->getStatusDisplayName()
                ]
            ];
        })->toArray();
        
        return view('employee.planning', compact('events', 'calendarEvents'));
    }

    public function tasks()
    {
        $user = auth()->user();
        $upcomingEvents = $user->upcomingEvents()->get();
        $completedEvents = $user->events()
            ->where('status', 'completed')
            ->orderBy('start_date', 'desc')
            ->get();
        
        return view('employee.tasks', compact('user', 'upcomingEvents', 'completedEvents'));
    }
}
