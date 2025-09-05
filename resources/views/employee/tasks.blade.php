<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Tâches - Finger's Cut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">Mes Tâches</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-700">Bienvenue, {{ auth()->user()->name }}</span>
                    <a href="{{ route('employee.dashboard') }}" 
                       class="relative group bg-blue-600 text-white w-12 h-12 rounded-full hover:bg-blue-700 transition duration-300 flex items-center justify-center"
                       title="Dashboard">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Dashboard
                        </span>
                    </a>
                    <a href="{{ route('employee.planning') }}" 
                       class="relative group bg-orange-600 text-white w-12 h-12 rounded-full hover:bg-orange-700 transition duration-300 flex items-center justify-center"
                       title="Planning">
                        <i class="fas fa-calendar text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Planning
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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Mes Tâches et Missions</h2>
                <p class="text-gray-600 mt-2">Gérez vos événements et projets assignés</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('employee.planning') }}" 
                   class="bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition duration-300 flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    Voir Planning
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-tasks text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $upcomingEvents->count() }}</h3>
                        <p class="text-gray-600">Tâches à venir</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $completedEvents->count() }}</h3>
                        <p class="text-gray-600">Tâches terminées</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $upcomingEvents->where('start_date', '<=', now()->addDays(7)->toDateString())->count() }}</h3>
                        <p class="text-gray-600">Cette semaine</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="showTab('upcoming')" id="upcoming-tab" class="tab-button active py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                        <i class="fas fa-clock mr-2"></i>
                        Tâches à venir ({{ $upcomingEvents->count() }})
                    </button>
                    <button onclick="showTab('completed')" id="completed-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i class="fas fa-check-circle mr-2"></i>
                        Tâches terminées ({{ $completedEvents->count() }})
                    </button>
                </nav>
            </div>

            <!-- Upcoming Tasks Tab -->
            <div id="upcoming-content" class="tab-content p-6">
                @if($upcomingEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition duration-300">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="w-4 h-4 rounded-full mt-2" style="background-color: {{ $event->color }}"></div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $event->getFormattedDateRange() }}
                                        </span>
                                        @if($event->start_time)
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $event->start_time->format('H:i') }}
                                            @if($event->end_time)
                                            - {{ $event->end_time->format('H:i') }}
                                            @endif
                                        </span>
                                        @endif
                                    </div>
                                    @if($event->description)
                                    <p class="text-gray-600 mb-3">{{ $event->description }}</p>
                                    @endif
                                    @if($event->getFormattedAddress())
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $event->getFormattedAddress() }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $event->getStatusColor() }}">
                                    {{ $event->getStatusDisplayName() }}
                                </span>
                                @if($event->start_date->isToday())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Aujourd'hui
                                </span>
                                @elseif($event->start_date->isTomorrow())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Demain
                                </span>
                                @elseif($event->start_date->diffInDays(now()) <= 7)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Cette semaine
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-tasks text-4xl mb-4"></i>
                    <p class="text-lg font-medium">Aucune tâche à venir</p>
                    <p class="text-sm">Vos nouvelles missions apparaîtront ici une fois assignées.</p>
                </div>
                @endif
            </div>

            <!-- Completed Tasks Tab -->
            <div id="completed-content" class="tab-content p-6 hidden">
                @if($completedEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($completedEvents as $event)
                    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4">
                                <div class="w-4 h-4 rounded-full mt-2" style="background-color: {{ $event->color }}"></div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $event->getFormattedDateRange() }}
                                        </span>
                                        @if($event->start_time)
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $event->start_time->format('H:i') }}
                                            @if($event->end_time)
                                            - {{ $event->end_time->format('H:i') }}
                                            @endif
                                        </span>
                                        @endif
                                    </div>
                                    @if($event->description)
                                    <p class="text-gray-600 mb-3">{{ $event->description }}</p>
                                    @endif
                                    @if($event->getFormattedAddress())
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $event->getFormattedAddress() }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col items-end space-y-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $event->getStatusColor() }}">
                                    {{ $event->getStatusDisplayName() }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    Terminé le {{ $event->updated_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-check-circle text-4xl mb-4"></i>
                    <p class="text-lg font-medium">Aucune tâche terminée</p>
                    <p class="text-sm">Vos tâches terminées apparaîtront ici.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }

        // Initialize with upcoming tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('upcoming');
        });
    </script>
</body>
</html>
