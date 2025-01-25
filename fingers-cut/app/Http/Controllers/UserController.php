<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user)
    {
        $user->update([
            'name' => 'Utilisateur supprimé',
            'email' => 'deleted_' . $user->id . '@example.com',
            'password' => bcrypt(uniqid()), // Génère un mot de passe aléatoire
            'role_id' => 2, // Lui donner un rôle neutre
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur anonymisé.');
    }
}
