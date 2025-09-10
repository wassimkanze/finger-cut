<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning - Finger's Cut Admin</title>
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
                    <h1 class="text-2xl font-bold text-blue-600">Finger's Cut - Planning</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-700">Bienvenue, {{ auth()->user()->name }}</span>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="relative group bg-blue-600 text-white w-12 h-12 rounded-full hover:bg-blue-700 transition duration-300 flex items-center justify-center"
                       title="Dashboard">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Dashboard
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
                <h2 class="text-3xl font-bold text-gray-900">Planning des Événements</h2>
                <p class="text-gray-600 mt-2">Gérez les événements et assignez les employés</p>
            </div>
            <button onclick="openCreateEventModal()" 
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Nouvel Événement
            </button>
        </div>

        <!-- FullCalendar -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div id="successMessage" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div id="errorMessage" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    </div>
    @endif

    <!-- Success Toast -->
    <div id="successToast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="successToastMsg">Événement créé avec succès.</span>
    </div>

    <!-- Error Toast -->
    <div id="errorToast" class="fixed top-20 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <span id="errorToastMsg">Erreur lors de la création.</span>
    </div>

    <!-- Create Event Modal -->
    <div id="createEventModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-4xl w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="createEventModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Nouvel Événement</h2>
                <button onclick="closeCreateEventModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="createEventForm" method="POST" action="{{ route('admin.events.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colonne de gauche -->
                    <div class="space-y-6">
                        <!-- Titre et couleur -->
                        <div class="flex items-end space-x-4">
                            <div class="flex-1">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                                <input id="title" type="text" name="title" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div class="flex flex-col items-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                                <div class="flex space-x-2">
                                    <input type="hidden" id="color" name="color" value="#3B82F6">
                                    <button type="button" onclick="selectColor('#3B82F6')" class="color-btn w-8 h-8 bg-blue-500 rounded-full border-2 border-blue-600 hover:scale-110 transition-all duration-200" data-color="#3B82F6"></button>
                                    <button type="button" onclick="selectColor('#EF4444')" class="color-btn w-8 h-8 bg-red-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#EF4444"></button>
                                    <button type="button" onclick="selectColor('#10B981')" class="color-btn w-8 h-8 bg-green-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#10B981"></button>
                                    <button type="button" onclick="selectColor('#F59E0B')" class="color-btn w-8 h-8 bg-yellow-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#F59E0B"></button>
                                    <button type="button" onclick="selectColor('#8B5CF6')" class="color-btn w-8 h-8 bg-purple-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#8B5CF6"></button>
                                    <button type="button" onclick="selectColor('#F97316')" class="color-btn w-8 h-8 bg-orange-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#F97316"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"></textarea>
                        </div>

                        <!-- Dates et heures -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                                <input id="start_date" type="date" name="start_date" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                                <input id="end_date" type="date" name="end_date" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Heure de début</label>
                                <input id="start_time" type="text" name="start_time" placeholder="ex: 14:30" 
                                       pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Heure de fin</label>
                                <input id="end_time" type="text" name="end_time" placeholder="ex: 16:00" 
                                       pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="space-y-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lieu/Nom du lieu</label>
                            <input id="location" type="text" name="location" placeholder="ex: Salle de réunion, Studio A, etc."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="number" class="block text-sm font-medium text-gray-700 mb-2">Numéro</label>
                                <input id="number" type="text" name="number" placeholder="ex: 123"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="street" class="block text-sm font-medium text-gray-700 mb-2">Rue</label>
                                <input id="street" type="text" name="street" placeholder="ex: Rue de la Paix"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                <input id="postal_code" type="text" name="postal_code" placeholder="ex: 75001"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input id="city" type="text" name="city" placeholder="ex: Paris"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <!-- Employés assignés -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employés assignés *</label>
                            <div class="max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-3 space-y-2">
                                @foreach($activeEmployees as $employee)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="user_ids[]" value="{{ $employee->id }}" 
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $employee->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="button" onclick="closeCreateEventModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                        Annuler
                    </button>
                    <button type="submit" id="createEventSubmit" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Créer l'événement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal d'options du jour -->
    <div id="dayOptionsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div id="dayOptionsModalContent" class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Options du <span id="selectedDate"></span></h2>
                <button onclick="closeDayOptionsModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="mb-4">
                <button onclick="viewDayPlanning()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 mb-2">
                    Voir les événements du jour
                </button>
                <button onclick="addEventToDay()" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition duration-300">
                    Créer un événement
                </button>
            </div>
        </div>
    </div>

    <!-- Conflict Confirmation Modal -->
    <div id="conflictModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-2xl w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="conflictModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-red-600">Conflit d'emploi du temps détecté</h2>
                <button onclick="closeConflictModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Nouvel événement à créer :</h3>
                    <div class="text-blue-700">
                        <p><strong>Titre :</strong> <span id="newEventTitle"></span></p>
                        <p><strong>Date :</strong> <span id="newEventDate"></span></p>
                        <p><strong>Heure :</strong> <span id="newEventTime"></span></p>
                    </div>
                </div>
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">Conflits détectés :</h3>
                    <div id="conflictsList" class="space-y-3">
                        <!-- Conflicts will be populated here -->
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="button" onclick="closeConflictModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                    Annuler
                </button>
                <button type="button" onclick="confirmCreateWithConflicts()" class="bg-orange-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-orange-700 transition duration-300">
                    Créer quand même
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Event Modal -->
    <div id="deleteEventModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="deleteEventModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Confirmer la suppression</h2>
                <button onclick="closeDeleteEventModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-700 mb-4">
                    Êtes-vous sûr de vouloir supprimer l'événement <strong id="deleteEventTitle"></strong> ?
                </p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-red-800">Attention</h4>
                            <p class="text-sm text-red-700 mt-1">
                                Cette action est irréversible. Toutes les assignations seront également supprimées.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <form id="deleteEventForm" method="POST" class="flex items-center justify-between">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteEventModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                    Annuler
                </button>
                <button type="submit" class="bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Modal affichant la liste des événements du jour -->
    <div id="dayEventsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div id="dayEventsModalContent" class="bg-white rounded-2xl p-8 max-w-lg w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Événements du <span id="dayEventsDate"></span></h2>
                <button onclick="closeDayEventsModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="dayEventsList"></div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div id="editEventModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-4xl w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="editEventModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Modifier l'Événement</h2>
                <button onclick="closeEditEventModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editEventForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Colonne de gauche -->
                    <div class="space-y-6">
                        <!-- Titre et couleur -->
                        <div class="flex items-end space-x-4">
                            <div class="flex-1">
                                <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                                <input id="edit_title" type="text" name="title" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div class="flex flex-col items-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                                <div class="flex space-x-2">
                                    <input type="hidden" id="edit_color" name="color" value="#3B82F6">
                                    <button type="button" onclick="selectEditColor('#3B82F6')" class="edit-color-btn w-8 h-8 bg-blue-500 rounded-full border-2 border-blue-600 hover:scale-110 transition-all duration-200" data-color="#3B82F6"></button>
                                    <button type="button" onclick="selectEditColor('#EF4444')" class="edit-color-btn w-8 h-8 bg-red-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#EF4444"></button>
                                    <button type="button" onclick="selectEditColor('#10B981')" class="edit-color-btn w-8 h-8 bg-green-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#10B981"></button>
                                    <button type="button" onclick="selectEditColor('#F59E0B')" class="edit-color-btn w-8 h-8 bg-yellow-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#F59E0B"></button>
                                    <button type="button" onclick="selectEditColor('#8B5CF6')" class="edit-color-btn w-8 h-8 bg-purple-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#8B5CF6"></button>
                                    <button type="button" onclick="selectEditColor('#F97316')" class="edit-color-btn w-8 h-8 bg-orange-500 rounded-full border-2 border-gray-300 hover:scale-110 transition-all duration-200" data-color="#F97316"></button>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="edit_description" name="description" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"></textarea>
                        </div>

                        <!-- Dates et heures -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_start_date" class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                                <input id="edit_start_date" type="date" name="start_date" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="edit_end_date" class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                                <input id="edit_end_date" type="date" name="end_date" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_start_time" class="block text-sm font-medium text-gray-700 mb-2">Heure de début</label>
                                <input id="edit_start_time" type="text" name="start_time" placeholder="ex: 14:30" 
                                       pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="edit_end_time" class="block text-sm font-medium text-gray-700 mb-2">Heure de fin</label>
                                <input id="edit_end_time" type="text" name="end_time" placeholder="ex: 16:00" 
                                       pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="space-y-6">
                        <!-- Location -->
                        <div>
                            <label for="edit_location" class="block text-sm font-medium text-gray-700 mb-2">Lieu/Nom du lieu</label>
                            <input id="edit_location" type="text" name="location" placeholder="ex: Salle de réunion, Studio A, etc."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        </div>

                        <!-- Adresse -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_street" class="block text-sm font-medium text-gray-700 mb-2">Rue</label>
                                <input id="edit_street" type="text" name="street" placeholder="ex: Rue de la Paix"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="edit_number" class="block text-sm font-medium text-gray-700 mb-2">Numéro</label>
                                <input id="edit_number" type="text" name="number" placeholder="ex: 123"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_postal_code" class="block text-sm font-medium text-gray-700 mb-2">Code postal</label>
                                <input id="edit_postal_code" type="text" name="postal_code" placeholder="ex: 75001"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                            
                            <div>
                                <label for="edit_city" class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input id="edit_city" type="text" name="city" placeholder="ex: Paris"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            </div>
                        </div>

                        <!-- Employés assignés -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employés assignés</label>
                            <div class="border border-gray-300 rounded-lg p-4 max-h-48 overflow-y-auto">
                                <div id="edit_employees_list" class="space-y-2">
                                    <!-- Les employés seront chargés ici -->
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeEditEventModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                            Annuler
                        </button>
                        <button type="button" id="deleteEventBtn" class="bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                    <button type="submit" id="editEventSubmit" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var calendar; // rendre globale
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
                    right: ''
                },
                events: @json($calendarEvents),
                eventClick: function(info) {
                    openEditEventModal(info.event.id);
                },
                dateClick: function(info) {
                    const clickedDate = new Date(info.dateStr);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    selectedDateForOptions = info.dateStr;
                    if (clickedDate < today) {
                        viewDayPlanning(); // modal recap events
                    } else {
                        openDayOptionsModal(info.dateStr); // modal options (ajout possible)
                    }
                }
            });
            calendar.render();
        });

        // Modal Functions
        function openCreateEventModal() {
            const modal = document.getElementById('createEventModal');
            const modalContent = document.getElementById('createEventModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeCreateEventModal() {
            const modal = document.getElementById('createEventModal');
            const modalContent = document.getElementById('createEventModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        function openDeleteEventModal(eventId, eventTitle) {
            const modal = document.getElementById('deleteEventModal');
            const modalContent = document.getElementById('deleteEventModalContent');
            const form = document.getElementById('deleteEventForm');
            const titleSpan = document.getElementById('deleteEventTitle');
            
            titleSpan.textContent = eventTitle;
            form.action = `/admin/events/${eventId}`;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteEventModal() {
            const modal = document.getElementById('deleteEventModal');
            const modalContent = document.getElementById('deleteEventModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        // Edit Event Modal Functions
        function openEditEventModal(eventId) {
            const event = calendar.getEventById(eventId);
            if (!event) {
                showErrorToast('Événement non trouvé.');
                return;
            }

            const eventEndDate = new Date(event.end || event.start);
            const today = new Date();
            today.setHours(23, 59, 59, 999); // Fin de la journée d'aujourd'hui

            if (eventEndDate < today) {
                showErrorToast('Impossible de modifier un événement passé.');
                return;
            }

            // Pré-remplir le formulaire avec les données de l'événement
            populateEditForm(event);
            
            // Ouvrir le modal
            const modal = document.getElementById('editEventModal');
            const modalContent = document.getElementById('editEventModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeEditEventModal() {
            const modal = document.getElementById('editEventModal');
            const modalContent = document.getElementById('editEventModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        function populateEditForm(event) {
            // Définir l'action du formulaire
            document.getElementById('editEventForm').action = `/admin/events/${event.id}`;
            
            // Titre
            document.getElementById('edit_title').value = event.title || '';
            
            // Description
            document.getElementById('edit_description').value = event.extendedProps?.description || '';
            
            // Couleur
            const color = event.backgroundColor || event.color || '#3B82F6';
            document.getElementById('edit_color').value = color;
            selectEditColor(color);
            
            // Dates
            const startDate = event.start ? event.start.toISOString().split('T')[0] : '';
            const endDate = event.end ? event.end.toISOString().split('T')[0] : startDate;
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_end_date').value = endDate;
            
            // Heures
            document.getElementById('edit_start_time').value = event.extendedProps?.start_time || '';
            document.getElementById('edit_end_time').value = event.extendedProps?.end_time || '';
            
            // Location
            document.getElementById('edit_location').value = event.extendedProps?.location || '';
            
            // Adresse
            document.getElementById('edit_street').value = event.extendedProps?.street || '';
            document.getElementById('edit_number').value = event.extendedProps?.number || '';
            document.getElementById('edit_postal_code').value = event.extendedProps?.postal_code || '';
            document.getElementById('edit_city').value = event.extendedProps?.city || '';
            

            
            // Employés assignés (à implémenter plus tard)
            loadEventEmployees(event.id);
            
            const deleteBtn = document.getElementById('deleteEventBtn');
            deleteBtn.onclick = function() {
                openDeleteEventModal(event.id, event.title);
            };
        }

        function selectEditColor(color) {
            document.getElementById('edit_color').value = color;
            
            document.querySelectorAll('.edit-color-btn').forEach(btn => {
                if (btn.dataset.color === color) {
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-blue-600', 'ring-2', 'ring-blue-200');
                } else {
                    btn.classList.remove('border-blue-600', 'ring-2', 'ring-blue-200');
                    btn.classList.add('border-gray-300');
                }
            });
        }

        function loadEventEmployees(eventId) {
            const employeesList = document.getElementById('edit_employees_list');
            employeesList.innerHTML = '<div class="text-gray-500 text-sm">Chargement des employés assignés...</div>';
            
            // Pour l'instant, on utilise les employés disponibles dans la page
            // Plus tard, on pourra charger les employés assignés via AJAX
            const activeEmployees = @json($activeEmployees ?? []);
            const event = calendar.getEventById(eventId);
            const assignedUserNames = event.extendedProps?.users ? event.extendedProps.users.split(', ') : [];
            
            let html = '';
            activeEmployees.forEach(employee => {
                const isAssigned = assignedUserNames.includes(employee.name);
                html += `
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="user_ids[]" value="${employee.id}" 
                               ${isAssigned ? 'checked' : ''}
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">${employee.name}</span>
                    </label>
                `;
            });
            
            employeesList.innerHTML = html || '<div class="text-gray-500 text-sm">Aucun employé disponible</div>';
        }

        // Close modals when clicking outside
        document.getElementById('createEventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateEventModal();
            }
        });

        document.getElementById('deleteEventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteEventModal();
            }
        });

        document.getElementById('editEventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditEventModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const createModal = document.getElementById('createEventModal');
                const deleteModal = document.getElementById('deleteEventModal');
                const editModal = document.getElementById('editEventModal');
                
                if (!createModal.classList.contains('hidden')) {
                    closeCreateEventModal();
                } else if (!deleteModal.classList.contains('hidden')) {
                    closeDeleteEventModal();
                } else if (!editModal.classList.contains('hidden')) {
                    closeEditEventModal();
                }
            }
        });



        // Time validation
        function validateTimeFormat(input) {
            const value = input.value.trim();
            if (value === '') {
                input.classList.remove('border-red-500', 'border-green-500');
                input.classList.add('border-gray-300');
                return;
            }
            
            const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
            if (timeRegex.test(value)) {
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
            } else {
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const timeInputs = document.querySelectorAll('input[name="start_time"], input[name="end_time"]');
            timeInputs.forEach(input => {
                // Validate on blur (when leaving the field)
                input.addEventListener('blur', function() {
                    validateTimeFormat(this);
                });
                
                // Validate on input (real-time)
                input.addEventListener('input', function() {
                    validateTimeFormat(this);
                });
            });

            const editTimeInputs = document.querySelectorAll('#editEventForm input[name="start_time"], #editEventForm input[name="end_time"]');
            editTimeInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateTimeFormat(this);
                });
                
                input.addEventListener('input', function() {
                    validateTimeFormat(this);
                });
            });
        });

        // Form submission with conflict detection
        document.getElementById('createEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('createEventSubmit');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Vérification...';
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                if (response.status === 409) {
                    const data = await response.json();
                    if (data.conflicts) {
                        showConflictModal(data);
                        return;
                    }
                }
                if (response.ok) {
                    closeCreateEventModal();
                    showSuccessToast('Événement créé avec succès.');
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    let msg = 'Erreur lors de la création.';
                    try {
                        const data = await response.json();
                        if (data.errors) {
                            msg = Object.values(data.errors).flat().join(' ');
                        }
                    } catch (e) {
                        const text = await response.text();
                        msg = text;
                    }
                    showErrorToast(msg);
                }
            })
            .catch(async error => {
                let msg = 'Erreur lors de la création.';
                if (error.response && error.response.status === 422) {
                    try {
                        const data = await error.response.json();
                        if (data.errors) {
                            msg = Object.values(data.errors).flat().join(' ');
                        }
                    } catch (e) {
                        // Si ce n'est pas du JSON, affiche le texte brut
                        const text = await error.response.text();
                        msg = text;
                    }
                } else if (error.response) {
                    const text = await error.response.text();
                    msg = text;
                }
                showErrorToast(msg);
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        // Edit Event Form submission
        document.getElementById('editEventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('editEventSubmit');
            const originalText = submitBtn.textContent;
            
            // Debug: afficher les données envoyées
            console.log('Form action:', this.action);
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }
            
            submitBtn.textContent = 'Enregistrement...';
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'PUT',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (response.ok) {
                    closeEditEventModal();
                    showSuccessToast('Événement modifié avec succès.');
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    let msg = 'Erreur lors de la modification.';
                    try {
                        const data = await response.json();
                        console.log('Error response data:', data);
                        if (data.errors) {
                            msg = Object.values(data.errors).flat().join(' ');
                        }
                    } catch (e) {
                        const text = await response.text();
                        console.log('Error response text:', text);
                        msg = text;
                    }
                    showErrorToast(msg);
                }
            })
            .catch(async error => {
                let msg = 'Erreur lors de la modification.';
                if (error.response && error.response.status === 422) {
                    try {
                        const data = await error.response.json();
                        if (data.errors) {
                            msg = Object.values(data.errors).flat().join(' ');
                        }
                    } catch (e) {
                        const text = await error.response.text();
                        msg = text;
                    }
                } else if (error.response) {
                    const text = await error.response.text();
                    msg = text;
                }
                showErrorToast(msg);
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        // Conflict modal functions
        function showConflictModal(data) {
            const modal = document.getElementById('conflictModal');
            const modalContent = document.getElementById('conflictModalContent');
            
            // Populate new event info
            document.getElementById('newEventTitle').textContent = data.newEvent.title;
            document.getElementById('newEventDate').textContent = formatDateRange(data.newEvent.start_date, data.newEvent.end_date);
            document.getElementById('newEventTime').textContent = formatTimeRange(data.newEvent.start_time, data.newEvent.end_time);
            
            // Populate conflicts
            const conflictsList = document.getElementById('conflictsList');
            conflictsList.innerHTML = '';
            
            Object.entries(data.conflicts).forEach(([userName, events]) => {
                const userDiv = document.createElement('div');
                userDiv.className = 'border-l-4 border-red-400 pl-3';
                userDiv.innerHTML = `
                    <h4 class="font-semibold text-red-800">${userName}</h4>
                    <div class="space-y-1 mt-1">
                        ${events.map(event => `
                            <div class="text-sm text-red-700">
                                <strong>${event.title}</strong> - ${formatDateRange(event.start_date, event.end_date)}
                                ${event.start_time ? ` (${event.start_time} - ${event.end_time || '--'})` : ''}
                            </div>
                        `).join('')}
                    </div>
                `;
                conflictsList.appendChild(userDiv);
            });
            
            // Store form data for later submission
            modal.dataset.formData = JSON.stringify(Object.fromEntries(new FormData(document.getElementById('createEventForm'))));
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeConflictModal() {
            const modal = document.getElementById('conflictModal');
            const modalContent = document.getElementById('conflictModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        function confirmCreateWithConflicts() {
            const modal = document.getElementById('conflictModal');
            const formData = JSON.parse(modal.dataset.formData);
            formData.ignore_conflicts = '1';
            
            const submitBtn = document.getElementById('createEventSubmit');
            submitBtn.textContent = 'Création...';
            submitBtn.disabled = true;
            
            fetch('{{ route("admin.events.store") }}', {
                method: 'POST',
                body: new URLSearchParams(formData),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(() => {
                // Recharger la page pour mettre à jour les indicateurs
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.reload();
            });
        }

        function formatDateRange(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            
            if (start.toDateString() === end.toDateString()) {
                return start.toLocaleDateString('fr-FR');
            } else {
                return `${start.toLocaleDateString('fr-FR')} - ${end.toLocaleDateString('fr-FR')}`;
            }
        }

        function formatTimeRange(startTime, endTime) {
            if (!startTime) return 'Toute la journée';
            if (!endTime) return `${startTime}`;
            return `${startTime} - ${endTime}`;
        }

        // Day options modal functionality
        let selectedDateForOptions = '';

        function openDayOptionsModal(dateStr) {
            selectedDateForOptions = dateStr;
            const modal = document.getElementById('dayOptionsModal');
            const modalContent = document.getElementById('dayOptionsModalContent');
            const dateSpan = document.getElementById('selectedDate');
            
            // Format date for display
            const date = new Date(dateStr);
            dateSpan.textContent = date.toLocaleDateString('fr-FR', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeDayOptionsModal() {
            const modal = document.getElementById('dayOptionsModal');
            const modalContent = document.getElementById('dayOptionsModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        function viewDayPlanning() {
            closeDayOptionsModal();
            const events = getEventsForDate(selectedDateForOptions);
            console.log('Events for date', selectedDateForOptions, events); // debug
            const date = new Date(selectedDateForOptions);
            document.getElementById('dayEventsDate').textContent = date.toLocaleDateString('fr-FR', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            });
            const listDiv = document.getElementById('dayEventsList');
            listDiv.innerHTML = '';
            if (events.length > 0) {
                events.forEach(event => {
                    const color = event.backgroundColor || event.color || '#3B82F6';
                    const time = event.extendedProps && event.extendedProps.start_time ? event.extendedProps.start_time : (event.start ? event.start.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'}) : '');
                    const endTime = event.extendedProps && event.extendedProps.end_time ? event.extendedProps.end_time : (event.end ? event.end.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'}) : '');
                    const timeStr = time ? (endTime ? `${time} - ${endTime}` : time) : 'Toute la journée';
                    listDiv.innerHTML += `
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-3 h-3 rounded-full" style="background:${color}"></div>
                            <div>
                                <div class="font-semibold text-gray-900">${event.title}</div>
                                <div class="text-sm text-gray-500">${timeStr}</div>
                                ${event.extendedProps && event.extendedProps.description ? `<div class='text-xs text-gray-400 mt-1'>${event.extendedProps.description}</div>` : ''}
                            </div>
                        </div>
                    `;
                });
            } else {
                listDiv.innerHTML = '<div class="text-center text-gray-500 py-8">Aucun événement prévu ce jour-là.</div>';
            }
            const modal = document.getElementById('dayEventsModal');
            const modalContent = document.getElementById('dayEventsModalContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeDayEventsModal() {
            const modal = document.getElementById('dayEventsModal');
            const modalContent = document.getElementById('dayEventsModalContent');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            document.body.style.overflow = 'auto';
        }

        function addEventToDay() {
            closeDayOptionsModal();
            // Pré-remplit la date dans le modal de création
            document.getElementById('start_date').value = selectedDateForOptions;
            document.getElementById('end_date').value = selectedDateForOptions;
            openCreateEventModal();
        }

        function getEventsForDate(dateStr) {
            // Récupérer les événements pour une date donnée depuis le calendrier
            const events = calendar.getEvents();
            return events.filter(event => {
                const eventDate = event.start.toISOString().split('T')[0];
                return eventDate === dateStr;
            });
        }

        // Color selection functionality
        function selectColor(color) {
            document.getElementById('color').value = color;
            
            document.querySelectorAll('.color-btn').forEach(btn => {
                if (btn.dataset.color === color) {
                    btn.classList.remove('border-gray-300');
                    btn.classList.add('border-blue-600', 'ring-2', 'ring-blue-200');
                } else {
                    btn.classList.remove('border-blue-600', 'ring-2', 'ring-blue-200');
                    btn.classList.add('border-gray-300');
                }
            });
        }

        // Close modals when clicking outside
        document.getElementById('conflictModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeConflictModal();
            }
        });

        document.getElementById('dayOptionsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDayOptionsModal();
            }
        });

        // Auto-hide success/error messages
        setTimeout(() => {
            const messages = ['successMessage', 'errorMessage'];
            messages.forEach(id => {
                const message = document.getElementById(id);
                if (message) {
                    message.style.opacity = '0';
                    setTimeout(() => {
                        message.remove();
                    }, 300);
                }
            });
        }, 5000);

        document.getElementById('dayEventsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDayEventsModal();
            }
        });

        // Toast functions
        function showSuccessToast(message) {
            const toast = document.getElementById('successToast');
            const messageSpan = document.getElementById('successToastMsg');
            messageSpan.textContent = message;
            
            toast.classList.remove('hidden');
            toast.classList.add('flex');
            
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 3000);
        }

        function showErrorToast(message) {
            const toast = document.getElementById('errorToast');
            const messageSpan = document.getElementById('errorToastMsg');
            messageSpan.textContent = message;
            
            toast.classList.remove('hidden');
            toast.classList.add('flex');
            
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 5000);
        }

        // Afficher le toast si session('success') existe (pour fallback classique)
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('successToast');
            if (toast && toast.dataset.show === '1') {
                toast.classList.remove('hidden');
                toast.classList.add('flex');
                setTimeout(() => {
                    toast.classList.add('hidden');
                    toast.classList.remove('flex');
                }, 2000);
            }
        });
    </script>
</body>
</html> 