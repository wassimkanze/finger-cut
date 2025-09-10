<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Notification;
use App\Models\InvitationCode;
use App\Models\ContactMessage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalEmployees = User::where('role', 'employé')->count();
        $unreadContactMessages = ContactMessage::active()->unread()->count();
        
        return view('admin.dashboard', compact('users', 'totalUsers', 'totalAdmins', 'totalEmployees', 'unreadContactMessages'));
    }

    public function users()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Anonymize and deactivate user account
     */
    public function deactivateUser(User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        // Prevent deactivating other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver un autre administrateur.');
        }

        // Anonymize user data (GDPR compliant)
        $user->anonymize();

        return back()->with('success', 'Le compte a été désactivé et anonymisé avec succès.');
    }

    /**
     * Contact user - send email notification
     */
    public function contactUser(User $user)
    {
        // For now, we'll just return the user's email for manual contact
        return back()->with('info', 'Contactez ' . $user->name . ' à l\'adresse : ' . $user->email);
    }

    /**
     * Show planning page
     */
    public function planning()
    {
        $events = Event::with('activeUsers')->orderBy('start_date')->get();
        $activeEmployees = User::where('role', 'employé')
                              ->where('is_active', true)
                              ->whereNull('anonymized_at')
                              ->orderBy('name')
                              ->get();
        
        // Prepare events data for FullCalendar
        $calendarEvents = $events->map(function($event) {
            $eventData = [
                'id' => $event->id,
                'title' => $event->title,
                'color' => $event->color,
                'extendedProps' => [
                    'description' => $event->description,
                    'location' => $event->getFormattedAddress(),
                    'users' => $event->activeUsers->pluck('name')->implode(', '),
                    'status' => $event->getStatusDisplayName()
                ]
            ];
            
            // Gérer les événements existants (qui peuvent avoir des heures null) et les nouveaux (avec heures obligatoires)
            if ($event->start_time && $event->end_time) {
                // Événement avec heure
                $eventData['start'] = $event->start_date->format('Y-m-d') . 'T' . $event->start_time->format('H:i:s');
                $eventData['end'] = $event->end_date->format('Y-m-d') . 'T' . $event->end_time->format('H:i:s');
                $eventData['allDay'] = false;
            } else {
                // Événement all-day (pour les anciens événements sans heure)
                $eventData['start'] = $event->start_date->format('Y-m-d');
                $eventData['end'] = $event->end_date->format('Y-m-d');
                $eventData['allDay'] = true;
            }
            
            return $eventData;
        })->toArray();
        
        return view('admin.planning', compact('events', 'activeEmployees', 'calendarEvents'));
    }

    /**
     * Store new event
     */
    public function storeEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'end_time'   => ['required', 'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'],
            'location' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        // Check for scheduling conflicts
        $conflicts = [];
        foreach ($request->user_ids as $userId) {
            $user = User::find($userId);
            $existingEvents = Event::whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where(function($query) use ($request) {
                $query->whereDate('start_date', '<=', $request->end_date)
                      ->whereDate('end_date', '>=', $request->start_date);
            })
            ->get();

            if ($existingEvents->count() > 0) {
                $conflicts[$user->name] = $existingEvents;
            }
        }

        if (!empty($conflicts) && !$request->has('ignore_conflicts')) {
            \Log::info('Conflit détecté lors de la création d\'événement', [
                'user_ids' => $request->user_ids,
                'conflicts' => $conflicts,
                'new_event' => [
                    'title' => $request->title,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]
            ]);
            return response()->json([
                'conflicts' => $conflicts,
                'newEvent' => [
                    'title' => $request->title,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time
                ]
            ], 409); // Conflict status
        }

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'street' => $request->street,
            'number' => $request->number,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'color' => $request->color ?? '#3B82F6',
        ]);

        // Assign users to event
        $event->users()->attach($request->user_ids, ['role' => 'assigned']);

        foreach ($request->user_ids as $userId) {
            Notification::createForUser(
                $userId,
                'event_assigned',
                'Nouvel événement assigné',
                "Vous avez été assigné à l'événement : {$event->title}",
                ['event_id' => $event->id]
            );
        }

        \Log::info('Event created', [
            'id' => $event->id,
            'title' => $event->title,
            'start_date' => $event->start_date,
            'end_date' => $event->end_date,
            'user_ids' => $request->user_ids
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Événement créé avec succès.');
    }

    /**
     * Update event
     */
    public function updateEvent(Request $request, Event $event)
    {
        \Log::info('Update event request', [
            'event_id' => $event->id,
            'request_data' => $request->all()
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
            'end_time' => 'required|regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/',
            'location' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:10',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'street' => $request->street,
            'number' => $request->number,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'color' => $request->color ?? '#3B82F6',
        ]);

        $event->users()->sync($request->user_ids);

        \Log::info('Event updated successfully', [
            'event_id' => $event->id,
            'title' => $event->title
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Événement mis à jour avec succès.');
    }

    /**
     * Delete event
     */
    public function deleteEvent(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Événement supprimé avec succès.');
    }

    /**
     * Generate invitation code
     */
    public function generateInvitationCode(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'role' => 'required|in:admin,employé',
            'expires_in_days' => 'nullable|integer|min:1|max:365'
        ]);

        $invitation = InvitationCode::createInvitation(
            $request->email,
            $request->role,
            $request->expires_in_days ?? 30
        );

        return back()->with('success', "Code d'invitation généré : {$invitation->code}");
    }

    /**
     * List invitation codes
     */
    public function invitationCodes()
    {
        $codes = InvitationCode::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.invitation-codes', compact('codes'));
    }

    /**
     * Revoke invitation code
     */
    public function revokeInvitationCode(InvitationCode $code)
    {
        $code->update(['used' => true]);
        return back()->with('success', 'Code d\'invitation révoqué.');
    }
}
