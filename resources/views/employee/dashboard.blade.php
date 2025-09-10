<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Employé - Finger's Cut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">Finger's Cut - Employé</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-700">Bienvenue, {{ auth()->user()->name }}</span>
                    <a href="{{ route('home') }}" 
                       class="relative group bg-blue-600 text-white w-12 h-12 rounded-full hover:bg-blue-700 transition duration-300 flex items-center justify-center"
                       title="Accueil">
                        <i class="fas fa-home text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Accueil
                        </span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="relative group bg-red-600 text-white w-12 h-12 rounded-full hover:bg-red-700 transition duration-300 flex items-center justify-center"
                                title="Déconnexion">
                            <i class="fas fa-power-off text-lg"></i>
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                Déconnexion
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Card -->
        <div class="bg-white rounded-lg shadow p-8 mb-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-tie text-3xl text-blue-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Bienvenue sur votre espace employé</h2>
                <p class="text-gray-600 mb-4">Vous êtes connecté en tant que <strong>{{ $user->getRoleDisplayName() }}</strong></p>
                <p class="text-gray-500">Accédez à vos outils et informations de travail.</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $stats['total_events'] }}</h3>
                        <p class="text-gray-600">Total Événements</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $stats['upcoming_events'] }}</h3>
                        <p class="text-gray-600">Événements à venir</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $stats['completed_events'] }}</h3>
                        <p class="text-gray-600">Événements terminés</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-user text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Mon Profil</h3>
                </div>
                <p class="text-gray-600 mb-4">Gérez vos informations personnelles et vos préférences.</p>
                <a href="{{ route('employee.profile') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    Voir mon profil
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-tasks text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Mes Tâches</h3>
                </div>
                <p class="text-gray-600 mb-4">Consultez vos missions et projets en cours.</p>
                <a href="{{ route('employee.tasks') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    Voir mes tâches
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                        <i class="fas fa-calendar text-xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Planning</h3>
                </div>
                <p class="text-gray-600 mb-4">Consultez votre planning et vos rendez-vous.</p>
                <a href="{{ route('employee.planning') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    Voir le planning
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Upcoming Events -->
        @if($upcomingEvents->count() > 0)
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Prochains Événements</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $event->color }}"></div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $event->getFormattedDateRange() }}</p>
                            @if($event->getFormattedAddress())
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $event->getFormattedAddress() }}
                            </p>
                            @endif
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $event->getStatusColor() }}">
                            {{ $event->getStatusDisplayName() }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Activité Récente</h2>
            </div>
            <div class="p-6">
                @if($recentEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($recentEvents as $event)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $event->color }}"></div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $event->getFormattedDateRange() }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $event->getStatusColor() }}">
                            {{ $event->getStatusDisplayName() }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-info-circle text-4xl mb-4"></i>
                    <p>Aucune activité récente à afficher.</p>
                    <p class="text-sm">Vos actions et activités apparaîtront ici.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html> 