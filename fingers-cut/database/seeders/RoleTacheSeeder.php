<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tache;
use App\Models\User;
use Database\Factories\RoleTache;
use Illuminate\Database\Seeder;

class RoleTacheSeeder extends Seeder
{
    public function run()
    {
        // Créer des rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Créer une tâche
        $planning = Tache::firstOrCreate(['name' => 'planning']);

        // Trouver l'utilisateur "Test User"
        $user = User::where('email', 'test@example.com')->first();

        if ($user) {
            RoleTache::firstOrCreate([
                'user_id' => $user->id,
                'tache_id' => $planning->id,
                'can_view' => true,  // Peut voir la tâche
                'can_edit' => true,  // Peut modifier la tâche
            ]);
        }
    }
}
