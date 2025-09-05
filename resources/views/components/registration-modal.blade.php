<!-- Modal d'inscription -->
<div x-data="{ 
    show: false,
    form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        invitation_code: ''
    },
    errors: {},
    loading: false,
    
    open() {
        this.show = true;
        this.resetForm();
    },
    
    close() {
        this.show = false;
        this.resetForm();
    },
    
    resetForm() {
        this.form = {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            invitation_code: ''
        };
        this.errors = {};
        this.loading = false;
    },
    
    async submit() {
        this.loading = true;
        this.errors = {};
        
        try {
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(this.form)
            });
            
            const data = await response.json();
            
            if (response.ok) {
                // Succès - rediriger vers la page de connexion avec message
                window.location.href = '/login?registered=1';
            } else {
                // Erreurs de validation
                if (data.errors) {
                    this.errors = data.errors;
                } else {
                    this.errors = { general: [data.message || 'Une erreur est survenue'] };
                }
            }
        } catch (error) {
            this.errors = { general: ['Erreur de connexion. Veuillez réessayer.'] };
        } finally {
            this.loading = false;
        }
    }
}" 
x-show="show" 
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
class="fixed inset-0 z-50 overflow-y-auto" 
style="display: none;"
@keydown.escape.window="close()"
@click.self="close()">
    
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white shadow-xl">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        Créer un compte
                    </h3>
                    <button @click="close()" 
                            class="text-white hover:text-gray-200 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="px-6 py-4">
                <form @submit.prevent="submit()" class="space-y-4">
                    <!-- Nom -->
                    <div>
                        <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nom complet
                        </label>
                        <input type="text" 
                               id="modal_name"
                               x-model="form.name"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Votre nom complet"
                               required>
                        <template x-if="errors.name">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.name[0]"></p>
                        </template>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="modal_email" class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse email
                        </label>
                        <input type="email" 
                               id="modal_email"
                               x-model="form.email"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="votre@email.com"
                               required>
                        <template x-if="errors.email">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.email[0]"></p>
                        </template>
                    </div>
                    
                    <!-- Mot de passe -->
                    <div>
                        <label for="modal_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Mot de passe
                        </label>
                        <input type="password" 
                               id="modal_password"
                               x-model="form.password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               placeholder="Minimum 8 caractères"
                               required>
                        <template x-if="errors.password">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.password[0]"></p>
                        </template>
                    </div>
                    
                    <!-- Confirmation mot de passe -->
                    <div>
                        <label for="modal_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmer le mot de passe
                        </label>
                        <input type="password" 
                               id="modal_password_confirmation"
                               x-model="form.password_confirmation"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror"
                               placeholder="Répétez votre mot de passe"
                               required>
                        <template x-if="errors.password_confirmation">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.password_confirmation[0]"></p>
                        </template>
                    </div>
                    
                    <!-- Code d'invitation -->
                    <div>
                        <label for="modal_invitation_code" class="block text-sm font-medium text-gray-700 mb-1">
                            Code d'invitation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="modal_invitation_code"
                               x-model="form.invitation_code"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('invitation_code') border-red-500 @enderror"
                               placeholder="Code fourni par votre administrateur"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            Contactez votre administrateur pour obtenir un code d'invitation.
                        </p>
                        <template x-if="errors.invitation_code">
                            <p class="mt-1 text-sm text-red-600" x-text="errors.invitation_code[0]"></p>
                        </template>
                    </div>
                    
                    <!-- Erreurs générales -->
                    <template x-if="errors.general">
                        <div class="bg-red-50 border border-red-200 rounded-md p-3">
                            <p class="text-sm text-red-600" x-text="errors.general[0]"></p>
                        </div>
                    </template>
                    
                    <!-- Boutons -->
                    <div class="flex space-x-3 pt-4">
                        <button type="button" 
                                @click="close()"
                                class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" 
                                :disabled="loading"
                                class="flex-1 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-md hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                            <span x-show="!loading">Créer le compte</span>
                            <span x-show="loading" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Création...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
