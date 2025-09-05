<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codes d'Invitation - Finger's Cut Admin</title>
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
                    <h1 class="text-2xl font-bold text-blue-600">Codes d'Invitation</h1>
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
                <h2 class="text-3xl font-bold text-gray-900">Gestion des Codes d'Invitation</h2>
                <p class="text-gray-600 mt-2">Générez et gérez les codes d'invitation pour les nouveaux utilisateurs</p>
            </div>
            <button onclick="openGenerateModal()" 
                    class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Générer un Code
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-key text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $codes->total() }}</h3>
                        <p class="text-gray-600">Total Codes</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $codes->where('used', false)->count() }}</h3>
                        <p class="text-gray-600">Codes Actifs</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-times-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $codes->where('used', true)->count() }}</h3>
                        <p class="text-gray-600">Codes Utilisés</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Codes Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Liste des Codes d'Invitation</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expire le</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé par</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($codes as $code)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <code class="text-sm font-mono bg-gray-100 px-2 py-1 rounded">{{ $code->code }}</code>
                                    <button onclick="copyToClipboard('{{ $code->code }}')" 
                                            class="ml-2 text-blue-600 hover:text-blue-800" title="Copier">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $code->email ?? 'Tous emails' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $code->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $code->role === 'admin' ? 'Administrateur' : 'Employé' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($code->used)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Utilisé
                                    </span>
                                @elseif($code->expires_at && $code->expires_at->isPast())
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Expiré
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Actif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $code->expires_at ? $code->expires_at->format('d/m/Y H:i') : 'Jamais' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $code->creator->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(!$code->used)
                                <form method="POST" action="{{ route('admin.invitation-codes.revoke', $code) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition duration-300"
                                            onclick="return confirm('Êtes-vous sûr de vouloir révoquer ce code ?')"
                                            title="Révoquer">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $codes->links() }}
            </div>
        </div>
    </div>

    <!-- Generate Code Modal -->
    <div id="generateModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="generateModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Générer un Code d'Invitation</h2>
                <button onclick="closeGenerateModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.invitation-codes.generate') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (optionnel)</label>
                    <input id="email" type="email" name="email" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                           placeholder="Laissez vide pour un code universel">
                    <p class="text-xs text-gray-500 mt-1">Si spécifié, seul cet email pourra utiliser le code</p>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rôle *</label>
                    <select id="role" name="role" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        <option value="employé">Employé</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>

                <div>
                    <label for="expires_in_days" class="block text-sm font-medium text-gray-700 mb-2">Expire dans (jours)</label>
                    <input id="expires_in_days" type="number" name="expires_in_days" value="30" min="1" max="365"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                </div>

                <div class="flex items-center justify-between">
                    <button type="button" onclick="closeGenerateModal()" class="bg-gray-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-600 transition duration-300">
                        Annuler
                    </button>
                    <button type="submit" class="bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 transition duration-300">
                        Générer le Code
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGenerateModal() {
            const modal = document.getElementById('generateModal');
            const modalContent = document.getElementById('generateModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeGenerateModal() {
            const modal = document.getElementById('generateModal');
            const modalContent = document.getElementById('generateModalContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            
            document.body.style.overflow = 'auto';
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check text-green-600"></i>';
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                }, 2000);
            });
        }

        // Close modal when clicking outside
        document.getElementById('generateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGenerateModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('generateModal');
                if (!modal.classList.contains('hidden')) {
                    closeGenerateModal();
                }
            }
        });
    </script>
</body>
</html>
