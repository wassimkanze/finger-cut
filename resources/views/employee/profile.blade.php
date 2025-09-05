<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Finger's Cut</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <a href="{{ route('employee.dashboard') }}" 
                       class="relative group bg-green-600 text-white w-12 h-12 rounded-full hover:bg-green-700 transition duration-300 flex items-center justify-center"
                       title="Dashboard">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Dashboard
                        </span>
                    </a>
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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Mon Profil</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Profile Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations Personnelles</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom</label>
                                <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rôle</label>
                                <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->getRoleDisplayName() }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Membre depuis</label>
                                <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Actions -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                        <div class="space-y-3">
                            <button onclick="openEditProfileModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                <i class="fas fa-edit mr-2"></i>
                                Modifier mon profil
                            </button>
                            
                            <button onclick="openChangePasswordModal()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300">
                                <i class="fas fa-key mr-2"></i>
                                Changer mon mot de passe
                            </button>
                        </div>
                    </div>
                </div>
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
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" 
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
        // Edit Profile Modal Functions
        function openEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            const modalContent = document.getElementById('editProfileModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger animation after a small delay
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            const modalContent = document.getElementById('editProfileModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            // Hide modal after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Change Password Modal Functions
        function openChangePasswordModal() {
            const modal = document.getElementById('changePasswordModal');
            const modalContent = document.getElementById('changePasswordModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger animation after a small delay
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeChangePasswordModal() {
            const modal = document.getElementById('changePasswordModal');
            const modalContent = document.getElementById('changePasswordModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            // Hide modal after animation
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
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
                const editModal = document.getElementById('editProfileModal');
                const passwordModal = document.getElementById('changePasswordModal');
                
                if (!editModal.classList.contains('hidden')) {
                    closeEditProfileModal();
                } else if (!passwordModal.classList.contains('hidden')) {
                    closeChangePasswordModal();
                }
            }
        });
    </script>
</body>
</html> 