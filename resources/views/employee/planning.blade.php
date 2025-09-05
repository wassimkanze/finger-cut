<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Planning - Finger's Cut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <style>
        #calendar {
            min-height: 600px;
            background: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">Mon Planning</h1>
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
                    <a href="{{ route('employee.tasks') }}" 
                       class="relative group bg-purple-600 text-white w-12 h-12 rounded-full hover:bg-purple-700 transition duration-300 flex items-center justify-center"
                       title="Mes Tâches">
                        <i class="fas fa-tasks text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Mes Tâches
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
                <h2 class="text-3xl font-bold text-gray-900">Mon Planning Personnel</h2>
                <p class="text-gray-600 mt-2">Consultez vos événements et rendez-vous assignés</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('employee.tasks') }}" 
                   class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center">
                    <i class="fas fa-tasks mr-2"></i>
                    Mes Tâches
                </a>
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
                        <h3 class="text-lg font-semibold text-gray-900">{{ $events->count() }}</h3>
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
                        <h3 class="text-lg font-semibold text-gray-900">{{ $events->where('start_date', '>=', now()->toDateString())->count() }}</h3>
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
                        <h3 class="text-lg font-semibold text-gray-900">{{ $events->where('status', 'completed')->count() }}</h3>
                        <p class="text-gray-600">Événements terminés</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FullCalendar -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div id="calendar"></div>
        </div>

        <!-- Events List -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Liste des Événements</h2>
            </div>
            <div class="p-6">
                @if($events->count() > 0)
                <div class="space-y-4">
                    @foreach($events as $event)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-300">
                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $event->color }}"></div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $event->getFormattedDateRange() }}</p>
                            @if($event->description)
                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($event->description, 100) }}</p>
                            @endif
                            @if($event->getFormattedAddress())
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $event->getFormattedAddress() }}
                            </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $event->getStatusColor() }}">
                                {{ $event->getStatusDisplayName() }}
                            </span>
                            @if($event->start_time)
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $event->start_time->format('H:i') }}
                                @if($event->end_time)
                                - {{ $event->end_time->format('H:i') }}
                                @endif
                            </p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-500 py-8">
                    <i class="fas fa-calendar-times text-4xl mb-4"></i>
                    <p>Aucun événement assigné.</p>
                    <p class="text-sm">Vos événements apparaîtront ici une fois assignés par l'administrateur.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div id="eventDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="eventDetailsModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900" id="eventTitle">Détails de l'événement</h2>
                <button onclick="closeEventDetailsModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="eventDetails" class="space-y-4">
                <!-- Event details will be populated here -->
            </div>
        </div>
    </div>

    <script>
        var calendar;
        
        // FullCalendar integration
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($calendarEvents),
                eventClick: function(info) {
                    showEventDetails(info.event);
                },
                eventDidMount: function(info) {
                    info.el.title = info.event.title;
                }
            });
            calendar.render();
        });

        function showEventDetails(event) {
            const modal = document.getElementById('eventDetailsModal');
            const modalContent = document.getElementById('eventDetailsModalContent');
            const titleEl = document.getElementById('eventTitle');
            const detailsEl = document.getElementById('eventDetails');
            
            titleEl.textContent = event.title;
            
            const props = event.extendedProps || {};
            const startDate = event.start ? event.start.toLocaleDateString('fr-FR') : '';
            const endDate = event.end ? event.end.toLocaleDateString('fr-FR') : '';
            const startTime = event.start ? event.start.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'}) : '';
            const endTime = event.end ? event.end.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'}) : '';
            
            let detailsHtml = `
                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold text-gray-700">Date</h3>
                        <p class="text-gray-600">${startDate}${startDate !== endDate ? ' - ' + endDate : ''}</p>
                    </div>
            `;
            
            if (startTime) {
                detailsHtml += `
                    <div>
                        <h3 class="font-semibold text-gray-700">Heure</h3>
                        <p class="text-gray-600">${startTime}${endTime ? ' - ' + endTime : ''}</p>
                    </div>
                `;
            }
            
            if (props.description) {
                detailsHtml += `
                    <div>
                        <h3 class="font-semibold text-gray-700">Description</h3>
                        <p class="text-gray-600">${props.description}</p>
                    </div>
                `;
            }
            
            if (props.location) {
                detailsHtml += `
                    <div>
                        <h3 class="font-semibold text-gray-700">Lieu</h3>
                        <p class="text-gray-600">${props.location}</p>
                    </div>
                `;
            }
            
            if (props.status) {
                detailsHtml += `
                    <div>
                        <h3 class="font-semibold text-gray-700">Statut</h3>
                        <p class="text-gray-600">${props.status}</p>
                    </div>
                `;
            }
            
            detailsHtml += '</div>';
            detailsEl.innerHTML = detailsHtml;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeEventDetailsModal() {
            const modal = document.getElementById('eventDetailsModal');
            const modalContent = document.getElementById('eventDetailsModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('eventDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEventDetailsModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('eventDetailsModal');
                if (!modal.classList.contains('hidden')) {
                    closeEventDetailsModal();
                }
            }
        });
    </script>
</body>
</html>
