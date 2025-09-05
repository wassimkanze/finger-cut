<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\InvitationCode;
use App\Rules\StrongPassword;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', new StrongPassword()],
            'invitation_code' => ['required', 'string', 'exists:invitation_codes,code'],
        ]);

        $invitation = InvitationCode::where('code', $request->invitation_code)
            ->valid()
            ->first();

        if (!$invitation) {
            return back()->withErrors([
                'invitation_code' => 'Code d\'invitation invalide ou expiré.'
            ])->withInput();
        }

        if ($invitation->email && $invitation->email !== $request->email) {
            return back()->withErrors([
                'email' => 'Cette invitation est destinée à un autre email.'
            ])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $invitation->role,
            'is_active' => true,
        ]);

        $invitation->markAsUsed();

        event(new Registered($user));

        return redirect()->route('home')->with('registered', true);
    }
}
