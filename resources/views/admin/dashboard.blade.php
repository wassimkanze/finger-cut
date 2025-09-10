<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Finger's Cut</title>
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
                    <h1 class="text-2xl font-bold text-blue-600">Finger's Cut - Admin</h1>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-700">Bienvenue, {{ auth()->user()->name }}</span>
                    <button onclick="openProfileOptionsModal()" 
                            class="relative group bg-green-600 text-white w-12 h-12 rounded-full hover:bg-green-700 transition duration-300 flex items-center justify-center"
                            title="Options du profil">
                        <i class="fas fa-user-edit text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Options du profil
                        </span>
                    </button>
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
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $totalUsers }}</h3>
                        <p class="text-gray-600">Total Utilisateurs</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-user-shield text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $totalAdmins }}</h3>
                        <p class="text-gray-600">Administrateurs</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-user-tie text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $totalEmployees }}</h3>
                        <p class="text-gray-600">Employés</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Planning</h3>
                        <p class="text-gray-600 mb-4">Gérer les événements et assigner les employés</p>
                        <a href="{{ route('admin.planning') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Accéder au planning
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-key text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Codes d'Invitation</h3>
                        <p class="text-gray-600 mb-4">Générer des codes pour les nouveaux utilisateurs</p>
                        <a href="{{ route('admin.invitation-codes') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Gérer les codes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Gestion des Utilisateurs</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->isAnonymized() ? 'bg-gray-100 text-gray-800' : ($user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $user->getRoleDisplayName() }}
                                </span>
                                @if($user->isAnonymized())
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 ml-2">
                                    {{ $user->getStatusDisplay() }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($user->id !== auth()->id() && !$user->isAnonymized())
                                <div class="flex space-x-2">
                                    <button onclick="openContactModal('{{ $user->name }}', '{{ $user->email }}')" 
                                            class="text-blue-600 hover:text-blue-800 transition duration-300"
                                            title="Contacter">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                    <button onclick="openDeactivateModal('{{ $user->name }}', '{{ $user->id }}')" 
                                            class="text-red-600 hover:text-red-800 transition duration-300"
                                            title="Désactiver">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                </div>
                                @elseif($user->isAnonymized())
                                <span class="text-gray-400">Compte désactivé</span>
                                @else
                                <span class="text-gray-400">Vous</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Profile Options Modal -->
    <div id="profileOptionsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="profileOptionsModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Options du profil</h2>
                <button onclick="closeProfileOptionsModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <button onclick="openEditProfileModal()" class="w-full flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-300">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-edit text-blue-600 text-xl"></i>
                    </div>
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900">Modifier mes informations</h3>
                        <p class="text-sm text-gray-600">Changer nom et email</p>
                    </div>
                </button>
                
                <button onclick="openChangePasswordModal()" class="w-full flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-key text-green-600 text-xl"></i>
                    </div>
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900">Changer mon mot de passe</h3>
                        <p class="text-sm text-gray-600">Mettre à jour le mot de passe</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="editProfileModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Modifier mon profil</h2>
                <button onclick="closeEditProfileModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                    <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="username" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Sauvegarder
                    </button>
                    <button type="button" onclick="closeEditProfileModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="changePasswordModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Changer le mot de passe</h2>
                <button onclick="closeChangePasswordModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')
                
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                    <input id="current_password" type="password" name="current_password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                        Changer le mot de passe
                    </button>
                    <button type="button" onclick="closeChangePasswordModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Profile Options Modal Functions
        function openProfileOptionsModal() {
            const modal = document.getElementById('profileOptionsModal');
            const modalContent = document.getElementById('profileOptionsModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeProfileOptionsModal() {
            const modal = document.getElementById('profileOptionsModal');
            const modalContent = document.getElementById('profileOptionsModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        // Edit Profile Modal Functions
        function openEditProfileModal() {
            closeProfileOptionsModal();
            
            const modal = document.getElementById('editProfileModal');
            const modalContent = document.getElementById('editProfileModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            const modalContent = document.getElementById('editProfileModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        // Change Password Modal Functions
        function openChangePasswordModal() {
            closeProfileOptionsModal();
            
            const modal = document.getElementById('changePasswordModal');
            const modalContent = document.getElementById('changePasswordModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeChangePasswordModal() {
            const modal = document.getElementById('changePasswordModal');
            const modalContent = document.getElementById('changePasswordModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('profileOptionsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProfileOptionsModal();
            }
        });

        document.getElementById('editProfileModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditProfileModal();
            }
        });

        document.getElementById('changePasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeChangePasswordModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const profileOptionsModal = document.getElementById('profileOptionsModal');
                const editProfileModal = document.getElementById('editProfileModal');
                const changePasswordModal = document.getElementById('changePasswordModal');
                const deactivateModal = document.getElementById('deactivateModal');
                const contactModal = document.getElementById('contactModal');
                
                if (!profileOptionsModal.classList.contains('hidden')) {
                    closeProfileOptionsModal();
                } else if (!editProfileModal.classList.contains('hidden')) {
                    closeEditProfileModal();
                } else if (!changePasswordModal.classList.contains('hidden')) {
                    closeChangePasswordModal();
                } else if (!deactivateModal.classList.contains('hidden')) {
                    closeDeactivateModal();
                } else if (!contactModal.classList.contains('hidden')) {
                    closeContactModal();
                }
            }
        });

        // Success/Error Messages
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

        @if(session('info'))
        <div id="infoMessage" class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                {{ session('info') }}
            </div>
        </div>
        @endif

        // Auto-hide success/error messages
        setTimeout(() => {
            const messages = ['successMessage', 'errorMessage', 'infoMessage'];
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
    </script>

    <!-- Deactivate Confirmation Modal -->
    <div id="deactivateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="deactivateModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Confirmer la désactivation</h2>
                <button onclick="closeDeactivateModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-700 mb-4">
                    Êtes-vous sûr de vouloir désactiver le compte de <strong id="deactivateUserName"></strong> ?
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-yellow-800">Attention</h4>
                            <p class="text-sm text-yellow-700 mt-1">
                                Cette action va anonymiser les données de l'utilisateur selon les standards RGPD. 
                                Le compte sera désactivé et ne pourra plus se connecter.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <form id="deactivateForm" method="POST" class="flex items-center justify-between">
                @csrf
                <button type="button" onclick="closeDeactivateModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                    Annuler
                </button>
                <button type="submit" class="bg-red-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                    Désactiver
                </button>
            </form>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="contactModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Contacter l'utilisateur</h2>
                <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <p class="text-gray-700 mb-4">
                    Contacter <strong id="contactUserName"></strong>
                </p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-700">
                                Email: <span id="contactUserEmail" class="font-mono"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button onclick="closeContactModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                    Fermer
                </button>
                <a id="contactEmailLink" href="#" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-envelope mr-2"></i>
                    Envoyer un email
                </a>
            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openDeactivateModal(userName, userId) {
            const modal = document.getElementById('deactivateModal');
            const modalContent = document.getElementById('deactivateModalContent');
            const form = document.getElementById('deactivateForm');
            const nameSpan = document.getElementById('deactivateUserName');
            
            nameSpan.textContent = userName;
            form.action = `/admin/users/${userId}/deactivate`;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeDeactivateModal() {
            const modal = document.getElementById('deactivateModal');
            const modalContent = document.getElementById('deactivateModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        function openContactModal(userName, userEmail) {
            const modal = document.getElementById('contactModal');
            const modalContent = document.getElementById('contactModalContent');
            const nameSpan = document.getElementById('contactUserName');
            const emailSpan = document.getElementById('contactUserEmail');
            const emailLink = document.getElementById('contactEmailLink');
            
            nameSpan.textContent = userName;
            emailSpan.textContent = userEmail;
            emailLink.href = `mailto:${userEmail}`;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeContactModal() {
            const modal = document.getElementById('contactModal');
            const modalContent = document.getElementById('contactModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('deactivateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeactivateModal();
            }
        });

        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeContactModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const deactivateModal = document.getElementById('deactivateModal');
                const contactModal = document.getElementById('contactModal');
                const editModal = document.getElementById('editProfileModal');
                
                if (!deactivateModal.classList.contains('hidden')) {
                    closeDeactivateModal();
                } else if (!contactModal.classList.contains('hidden')) {
                    closeContactModal();
                } else if (!editModal.classList.contains('hidden')) {
                    closeEditProfileModal();
                }
            }
        });
    </script>
</body>
</html> 