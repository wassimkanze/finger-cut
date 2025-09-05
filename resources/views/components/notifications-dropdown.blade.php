<div class="relative" x-data="{ open: false, notifications: [], unreadCount: 0 }" 
     x-init="
        loadNotifications();
        setInterval(() => loadNotifications(), 30000); // Refresh every 30 seconds
     ">
    <!-- Notification Bell -->
    <button @click="open = !open" 
            class="relative group bg-purple-600 text-white w-12 h-12 rounded-full hover:bg-purple-700 transition duration-300 flex items-center justify-center"
            title="Notifications">
        <i class="fas fa-bell text-lg"></i>
        <span x-show="unreadCount > 0" 
              x-text="unreadCount" 
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
        </span>
        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
            Notifications
        </span>
    </button>

    <!-- Dropdown -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
            <button @click="markAllAsRead()" 
                    class="text-sm text-blue-600 hover:text-blue-800"
                    x-show="unreadCount > 0">
                Tout marquer comme lu
            </button>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            <template x-if="notifications.length === 0">
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-bell-slash text-2xl mb-2"></i>
                    <p>Aucune notification</p>
                </div>
            </template>
            
            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer"
                     :class="{ 'bg-blue-50': !notification.read }"
                     @click="markAsRead(notification.id)">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i :class="getNotificationIcon(notification.type)" 
                               class="text-lg"
                               :class="getNotificationColor(notification.type)"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                            <p class="text-sm text-gray-600 mt-1" x-text="notification.message"></p>
                            <p class="text-xs text-gray-500 mt-1" x-text="formatDate(notification.created_at)"></p>
                        </div>
                        <div class="flex-shrink-0">
                            <button @click.stop="deleteNotification(notification.id)"
                                    class="text-gray-400 hover:text-red-500">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 border-t border-gray-200 text-center">
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Voir toutes les notifications</a>
        </div>
    </div>
</div>

<script>
function loadNotifications() {
    fetch('{{ route("notifications.index") }}')
        .then(response => response.json())
        .then(data => {
            this.notifications = data.notifications.data || [];
            this.unreadCount = data.unread_count || 0;
        })
        .catch(error => console.error('Error loading notifications:', error));
}

function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.unreadCount = data.unread_count;
            const notification = this.notifications.find(n => n.id === notificationId);
            if (notification) {
                notification.read = true;
            }
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

function markAllAsRead() {
    fetch('{{ route("notifications.mark-all-read") }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.unreadCount = 0;
            this.notifications.forEach(notification => {
                notification.read = true;
            });
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}

function deleteNotification(notificationId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.unreadCount = data.unread_count;
                this.notifications = this.notifications.filter(n => n.id !== notificationId);
            }
        })
        .catch(error => console.error('Error deleting notification:', error));
    }
}

function getNotificationIcon(type) {
    const icons = {
        'event_assigned': 'fas fa-calendar-plus',
        'event_updated': 'fas fa-calendar-check',
        'event_cancelled': 'fas fa-calendar-times',
        'general': 'fas fa-bell'
    };
    return icons[type] || 'fas fa-bell';
}

function getNotificationColor(type) {
    const colors = {
        'event_assigned': 'text-blue-600',
        'event_updated': 'text-yellow-600',
        'event_cancelled': 'text-red-600',
        'general': 'text-gray-600'
    };
    return colors[type] || 'text-gray-600';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInHours = Math.floor((now - date) / (1000 * 60 * 60));
    
    if (diffInHours < 1) {
        return 'Il y a quelques minutes';
    } else if (diffInHours < 24) {
        return `Il y a ${diffInHours}h`;
    } else if (diffInHours < 48) {
        return 'Hier';
    } else {
        return date.toLocaleDateString('fr-FR');
    }
}
</script>
