<x-guest-layout>
    <div x-data="{ showRegisterModal: false }">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Message de succès après inscription -->
        @if(session('registered'))
            <div class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">
                            Compte créé avec succès ! Vous pouvez maintenant vous connecter.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <div class="flex space-x-3">
                    <button type="button" 
                            @click="showRegisterModal = true"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        Créer un compte
                    </button>
                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </form>

        <!-- Modal d'inscription -->
        <div x-show="showRegisterModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             @keydown.escape.window="showRegisterModal = false"
             @click.self="showRegisterModal = false">
            
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
                     class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto transform overflow-hidden rounded-lg bg-white shadow-xl">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                Créer un compte
                            </h3>
                            <button @click="showRegisterModal = false" 
                                    class="text-white hover:text-gray-200 transition-colors">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="px-6 py-4">
                        <form method="POST" action="{{ route('register') }}" class="space-y-3">
                            @csrf
                            
                            <!-- Nom et Email en 2 colonnes -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nom complet
                                    </label>
                                    <input type="text" 
                                           id="modal_name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                           placeholder="Votre nom complet"
                                           required>
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="modal_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Adresse email
                                    </label>
                                    <input type="email" 
                                           id="modal_email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                           placeholder="votre@email.com"
                                           required>
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Mots de passe en 2 colonnes -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="modal_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Mot de passe
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="modal_password"
                                               name="password"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                               placeholder="Minimum 8 caractères"
                                               required
                                               oninput="validateModalPassword()">
                                        <button type="button" onclick="togglePasswordVisibility('modal_password')" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i id="modal_password_eye" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="modal_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirmer
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               id="modal_password_confirmation"
                                               name="password_confirmation"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror"
                                               placeholder="Répétez votre mot de passe"
                                               required
                                               oninput="validateModalPasswordConfirmation()">
                                        <button type="button" onclick="togglePasswordVisibility('modal_password_confirmation')" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <i id="modal_password_confirmation_eye" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Indicateurs de validation du mot de passe - Version compacte -->
                            <div id="modal_password_requirements" class="grid grid-cols-2 gap-1 text-xs">
                                <div class="flex items-center">
                                    <i id="modal_req_length" class="fas fa-times text-red-500 mr-1"></i>
                                    <span class="text-gray-600">8+ caractères</span>
                                </div>
                                <div class="flex items-center">
                                    <i id="modal_req_uppercase" class="fas fa-times text-red-500 mr-1"></i>
                                    <span class="text-gray-600">Majuscule</span>
                                </div>
                                <div class="flex items-center">
                                    <i id="modal_req_lowercase" class="fas fa-times text-red-500 mr-1"></i>
                                    <span class="text-gray-600">Minuscule</span>
                                </div>
                                <div class="flex items-center">
                                    <i id="modal_req_number" class="fas fa-times text-red-500 mr-1"></i>
                                    <span class="text-gray-600">Chiffre</span>
                                </div>
                                <div class="flex items-center col-span-2">
                                    <i id="modal_req_special" class="fas fa-times text-red-500 mr-1"></i>
                                    <span class="text-gray-600">Caractère spécial</span>
                                </div>
                                <div class="flex items-center col-span-2">
                                    <i id="modal_password_match_icon" class="fas fa-times text-red-500 mr-1"></i>
                                    <span id="modal_password_match_text" class="text-gray-600">Les mots de passe doivent correspondre</span>
                                </div>
                            </div>
                            
                            <!-- Code d'invitation -->
                            <div>
                                <label for="modal_invitation_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    Code d'invitation <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="modal_invitation_code"
                                       name="invitation_code"
                                       value="{{ old('invitation_code') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('invitation_code') border-red-500 @enderror"
                                       placeholder="Code fourni par votre administrateur"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">
                                    Contactez votre administrateur pour obtenir un code d'invitation.
                                </p>
                                @error('invitation_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Boutons -->
                            <div class="flex space-x-3 pt-4">
                                <button type="button" 
                                        @click="showRegisterModal = false"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                                    Annuler
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-md hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                    Créer le compte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        // Password Validation Functions for Modal
        function validateModalPassword() {
            const password = document.getElementById('modal_password').value;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };

            updateModalRequirementIndicator('modal_req_length', requirements.length);
            updateModalRequirementIndicator('modal_req_uppercase', requirements.uppercase);
            updateModalRequirementIndicator('modal_req_lowercase', requirements.lowercase);
            updateModalRequirementIndicator('modal_req_number', requirements.number);
            updateModalRequirementIndicator('modal_req_special', requirements.special);

            // Valider la confirmation du mot de passe
            validateModalPasswordConfirmation();

            const allValid = Object.values(requirements).every(req => req);
            
            const passwordField = document.getElementById('modal_password');
            if (allValid) {
                passwordField.classList.remove('border-red-500', 'focus:ring-red-500');
                passwordField.classList.add('border-green-500', 'focus:ring-green-500');
            } else {
                passwordField.classList.remove('border-green-500', 'focus:ring-green-500');
                passwordField.classList.add('border-red-500', 'focus:ring-red-500');
            }
        }

        function validateModalPasswordConfirmation() {
            const password = document.getElementById('modal_password').value;
            const confirmation = document.getElementById('modal_password_confirmation').value;
            const match = password === confirmation && password.length > 0;

            updateModalRequirementIndicator('modal_password_match_icon', match);
            
            const matchText = document.getElementById('modal_password_match_text');
            if (match) {
                matchText.textContent = 'Les mots de passe correspondent';
                matchText.classList.remove('text-gray-600');
                matchText.classList.add('text-green-600');
            } else {
                matchText.textContent = 'Les mots de passe doivent correspondre';
                matchText.classList.remove('text-green-600');
                matchText.classList.add('text-gray-600');
            }

            const confirmationField = document.getElementById('modal_password_confirmation');
            if (match && confirmation.length > 0) {
                confirmationField.classList.remove('border-red-500', 'focus:ring-red-500');
                confirmationField.classList.add('border-green-500', 'focus:ring-green-500');
            } else if (confirmation.length > 0) {
                confirmationField.classList.remove('border-green-500', 'focus:ring-green-500');
                confirmationField.classList.add('border-red-500', 'focus:ring-red-500');
            } else {
                confirmationField.classList.remove('border-red-500', 'focus:ring-red-500', 'border-green-500', 'focus:ring-green-500');
            }
        }

        function updateModalRequirementIndicator(elementId, isValid) {
            const icon = document.getElementById(elementId);
            if (isValid) {
                icon.classList.remove('fa-times', 'text-red-500');
                icon.classList.add('fa-check', 'text-green-500');
            } else {
                icon.classList.remove('fa-check', 'text-green-500');
                icon.classList.add('fa-times', 'text-red-500');
            }
        }

        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '_eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
