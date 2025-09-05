<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Finger\'s Cut',
            'email' => 'admin@fingerscut.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $employees = [
            [
                'name' => 'Marie Dubois',
                'email' => 'marie.dubois@fingerscut.com',
                'role' => 'employé',
            ],
            [
                'name' => 'Pierre Martin',
                'email' => 'pierre.martin@fingerscut.com',
                'role' => 'employé',
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@fingerscut.com',
                'role' => 'employé',
            ],
            [
                'name' => 'Thomas Moreau',
                'email' => 'thomas.moreau@fingerscut.com',
                'role' => 'employé',
            ],
        ];

        $createdEmployees = [];
        foreach ($employees as $employeeData) {
            $employee = User::create([
                'name' => $employeeData['name'],
                'email' => $employeeData['email'],
                'password' => Hash::make('password'),
                'role' => $employeeData['role'],
                'is_active' => true,
            ]);
            $createdEmployees[] = $employee;
        }

        $events = [
            [
                'title' => 'Tournage Publicité Automobile',
                'description' => 'Tournage d\'une publicité pour une marque automobile dans les studios de Paris.',
                'start_date' => now()->addDays(2),
                'end_date' => now()->addDays(2),
                'start_time' => '09:00',
                'end_time' => '17:00',
                'location' => 'Studio A',
                'street' => 'Rue de la Production',
                'number' => '15',
                'postal_code' => '75012',
                'city' => 'Paris',
                'color' => '#3B82F6',
                'status' => 'planned',
            ],
            [
                'title' => 'Clip Musical - Artiste Indé',
                'description' => 'Réalisation d\'un clip musical pour un artiste indépendant.',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(6),
                'start_time' => '10:00',
                'end_time' => '18:00',
                'location' => 'Studio B',
                'street' => 'Avenue des Artistes',
                'number' => '42',
                'postal_code' => '75011',
                'city' => 'Paris',
                'color' => '#8B5CF6',
                'status' => 'planned',
            ],
            [
                'title' => 'Documentaire Entreprise',
                'description' => 'Tournage d\'un documentaire corporate pour une entreprise technologique.',
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(12),
                'start_time' => '08:00',
                'end_time' => '16:00',
                'location' => 'Siège Social TechCorp',
                'street' => 'Boulevard de l\'Innovation',
                'number' => '100',
                'postal_code' => '75008',
                'city' => 'Paris',
                'color' => '#10B981',
                'status' => 'planned',
            ],
            [
                'title' => 'Événement Mariage - Extérieur',
                'description' => 'Couverture vidéo d\'un mariage en extérieur dans un château.',
                'start_date' => now()->addDays(15),
                'end_date' => now()->addDays(15),
                'start_time' => '14:00',
                'end_time' => '22:00',
                'location' => 'Château de Versailles',
                'street' => 'Place d\'Armes',
                'number' => '1',
                'postal_code' => '78000',
                'city' => 'Versailles',
                'color' => '#F59E0B',
                'status' => 'planned',
            ],
            [
                'title' => 'Formation Vidéo Corporate',
                'description' => 'Formation interne sur les techniques de montage vidéo.',
                'start_date' => now()->subDays(3),
                'end_date' => now()->subDays(3),
                'start_time' => '14:00',
                'end_time' => '17:00',
                'location' => 'Salle de Formation',
                'street' => 'Rue de la Formation',
                'number' => '25',
                'postal_code' => '75013',
                'city' => 'Paris',
                'color' => '#EF4444',
                'status' => 'completed',
            ],
        ];

        $createdEvents = [];
        foreach ($events as $eventData) {
            $event = Event::create($eventData);
            $createdEvents[] = $event;
        }

        $createdEvents[0]->users()->attach([$createdEmployees[0]->id, $createdEmployees[1]->id], ['role' => 'assigned']);
        $createdEvents[1]->users()->attach([$createdEmployees[1]->id, $createdEmployees[2]->id], ['role' => 'assigned']);
        $createdEvents[2]->users()->attach([$createdEmployees[0]->id, $createdEmployees[2]->id, $createdEmployees[3]->id], ['role' => 'assigned']);
        $createdEvents[3]->users()->attach([$createdEmployees[3]->id], ['role' => 'assigned']);
        $createdEvents[4]->users()->attach([$createdEmployees[0]->id, $createdEmployees[1]->id, $createdEmployees[2]->id, $createdEmployees[3]->id], ['role' => 'assigned']);

        foreach ($createdEvents as $event) {
            foreach ($event->users as $user) {
                Notification::createForUser(
                    $user->id,
                    'event_assigned',
                    'Nouvel événement assigné',
                    "Vous avez été assigné à l'événement : {$event->title}",
                    ['event_id' => $event->id]
                );
            }
        }

        Notification::createForUser(
            $createdEmployees[0]->id,
            'general',
            'Bienvenue dans l\'équipe !',
            'Nous sommes ravis de vous accueillir dans l\'équipe Finger\'s Cut. N\'hésitez pas à explorer votre espace personnel.',
            null
        );

        Notification::createForUser(
            $createdEmployees[1]->id,
            'general',
            'Rappel : Formation sécurité',
            'N\'oubliez pas la formation sécurité prévue demain à 14h en salle de conférence.',
            null
        );

        $this->command->info('Test data created successfully!');
        $this->command->info('Admin: admin@fingerscut.com / password');
        $this->command->info('Employees: marie.dubois@fingerscut.com, pierre.martin@fingerscut.com, etc. / password');
    }
}