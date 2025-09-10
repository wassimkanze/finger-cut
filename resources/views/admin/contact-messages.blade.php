<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de Contact - Finger's Cut</title>
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
                    <a href="{{ route('admin.dashboard') }}" 
                       class="relative group bg-blue-600 text-white w-12 h-12 rounded-full hover:bg-blue-700 transition duration-300 flex items-center justify-center"
                       title="Dashboard">
                        <i class="fas fa-tachometer-alt text-lg"></i>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            Dashboard
                        </span>
                    </a>
                    <a href="{{ route('home') }}" 
                       class="relative group bg-green-600 text-white w-12 h-12 rounded-full hover:bg-green-700 transition duration-300 flex items-center justify-center"
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
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Messages de contact</h1>
                    <p class="mt-1 text-sm text-gray-500">Gérez les messages reçus via le formulaire de contact</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-envelope mr-1"></i>
                        {{ $unreadCount }} non lus
                    </div>
                    @if(isset($archivedCount) && $archivedCount > 0)
                        <div class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-archive mr-1"></i>
                            {{ $archivedCount }} archivés
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Vue :</label>
                    <select id="viewFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="changeView()">
                        <option value="active" {{ request('filter') !== 'archived' ? 'selected' : '' }}>Messages actifs</option>
                        <option value="archived" {{ request('filter') === 'archived' ? 'selected' : '' }}>Messages archivés</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Statut :</label>
                    <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les messages</option>
                        <option value="unread">Non lus</option>
                        <option value="read">Lus</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Type :</label>
                    <select id="typeFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les types</option>
                        <option value="Film publicitaire">Film publicitaire</option>
                        <option value="Clip musical">Clip musical</option>
                        <option value="Vidéo corporate">Vidéo corporate</option>
                        <option value="Événement">Événement</option>
                        <option value="Photographie">Photographie</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Messages List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if($messages->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                        <div class="p-6 hover:bg-gray-50 transition-colors {{ !$message->read ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}" 
                             data-status="{{ $message->read ? 'read' : 'unread' }}" 
                             data-type="{{ $message->project_type }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $message->full_name }}
                                        </h3>
                                        @if(!$message->read)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Nouveau
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $message->project_type }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope mr-1"></i>
                                            {{ $message->email }}
                                        </div>
                                        @if($message->phone)
                                            <div class="flex items-center">
                                                <i class="fas fa-phone mr-1"></i>
                                                {{ $message->phone }}
                                            </div>
                                        @endif
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $message->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ Str::limit($message->message, 200) }}
                                        @if(strlen($message->message) > 200)
                                            <button onclick="toggleMessage({{ $message->id }})" 
                                                    class="text-blue-600 hover:text-blue-800 ml-1">
                                                ...voir plus
                                            </button>
                                        @endif
                                    </p>
                                    
                                    <!-- Full message (hidden by default) -->
                                    <div id="full-message-{{ $message->id }}" class="hidden mt-3 p-4 bg-gray-100 rounded-lg">
                                        <p class="text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2 ml-4">
                                    @if($message->read)
                                        <button onclick="markAsUnread({{ $message->id }})" 
                                                class="text-gray-400 hover:text-blue-600 transition-colors"
                                                title="Marquer comme non lu">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    @else
                                        <button onclick="markAsRead({{ $message->id }})" 
                                                class="text-blue-600 hover:text-blue-800 transition-colors"
                                                title="Marquer comme lu">
                                            <i class="fas fa-envelope-open"></i>
                                        </button>
                                    @endif
                                    
                                    @if(request('filter') === 'archived')
                                        <button onclick="unarchiveMessage({{ $message->id }})" 
                                                class="text-green-400 hover:text-green-600 transition-colors"
                                                title="Désarchiver">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    @else
                                        <button onclick="archiveMessage({{ $message->id }})" 
                                                class="text-orange-400 hover:text-orange-600 transition-colors"
                                                title="Archiver">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun message</h3>
                    <p class="text-gray-500">Aucun message de contact n'a été reçu pour le moment.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
    // Change view (active/archived)
    function changeView() {
        const viewFilter = document.getElementById('viewFilter').value;
        const currentUrl = new URL(window.location);
        
        if (viewFilter === 'archived') {
            currentUrl.searchParams.set('filter', 'archived');
        } else {
            currentUrl.searchParams.delete('filter');
        }
        
        window.location.href = currentUrl.toString();
    }

    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', filterMessages);
    document.getElementById('typeFilter').addEventListener('change', filterMessages);

    function filterMessages() {
        const statusFilter = document.getElementById('statusFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const messages = document.querySelectorAll('[data-status]');
        
        messages.forEach(message => {
            const status = message.getAttribute('data-status');
            const type = message.getAttribute('data-type');
            
            let show = true;
            
            if (statusFilter && status !== statusFilter) {
                show = false;
            }
            
            if (typeFilter && type !== typeFilter) {
                show = false;
            }
            
            message.style.display = show ? 'block' : 'none';
        });
    }

    // Toggle full message
    function toggleMessage(messageId) {
        const fullMessage = document.getElementById('full-message-' + messageId);
        const button = event.target;
        
        if (fullMessage.classList.contains('hidden')) {
            fullMessage.classList.remove('hidden');
            button.textContent = '...voir moins';
        } else {
            fullMessage.classList.add('hidden');
            button.textContent = '...voir plus';
        }
    }

    // Mark as read
    function markAsRead(messageId) {
        fetch(`/admin/contact-messages/${messageId}/read`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }

    // Mark as unread
    function markAsUnread(messageId) {
        fetch(`/admin/contact-messages/${messageId}/unread`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }

    // Archive message
    function archiveMessage(messageId) {
        if (confirm('Êtes-vous sûr de vouloir archiver ce message ?')) {
            fetch(`/admin/contact-messages/${messageId}/archive`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        }
    }

    // Unarchive message
    function unarchiveMessage(messageId) {
        if (confirm('Êtes-vous sûr de vouloir désarchiver ce message ?')) {
            fetch(`/admin/contact-messages/${messageId}/unarchive`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue');
            });
        }
    }
    </script>
</body>
</html>