<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finger's Cut - Production Audiovisuelle</title>
    <meta name="description" content="Finger's Cut - Votre partenaire créatif pour la production audiovisuelle. Films, publicités, événements et plus encore.">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-gradient">Finger's Cut</h1>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#accueil" class="text-gray-700 hover:text-blue-600 transition duration-300">Accueil</a>
                    <a href="#services" class="text-gray-700 hover:text-blue-600 transition duration-300">Services</a>
                    <a href="#portfolio" class="text-gray-700 hover:text-blue-600 transition duration-300">Portfolio</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 transition duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('employee.dashboard') }}" 
                           class="relative group bg-green-600 text-white w-12 h-12 rounded-full hover:bg-green-700 transition duration-300 flex items-center justify-center"
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
                    @else
                        <button onclick="openLoginModal()" 
                                class="relative group bg-blue-600 text-white w-12 h-12 rounded-full hover:bg-blue-700 transition duration-300 flex items-center justify-center"
                                title="Connexion">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                Connexion
                            </span>
                        </button>
                    @endauth
                </div>
                <div class="md:hidden flex items-center">
                    <button class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Message de succès après inscription -->
    @if(session('registered'))
        <div id="successNotification" class="fixed top-4 right-4 z-50 max-w-sm transform transition-all duration-500 ease-in-out translate-x-full opacity-0">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-lg">
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
                    <div class="ml-auto pl-3">
                        <button onclick="hideSuccessNotification()" class="text-green-400 hover:text-green-600 transition-colors">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section id="accueil" class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-6">
                Finger's Cut
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                Créons ensemble des histoires visuelles qui captivent et inspirent
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#services" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition duration-300">
                    Nos Services
                </a>
                <a href="#portfolio" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    Voir Portfolio
                </a>
            </div>
        </div>
        
        <!-- Parallax background elements -->
        <div id="parallax-balls"></div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Nos Services</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    De la conception à la diffusion, nous vous accompagnons dans tous vos projets audiovisuels
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-video text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Production Vidéo</h3>
                    <p class="text-gray-600 mb-6">
                        Films publicitaires, clips musicaux, vidéos corporate et documentaires. Notre équipe expérimentée assure une production de qualité professionnelle.
                    </p>
                    <ul class="text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Scénarisation</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Réalisation</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Montage</li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-camera text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Photographie</h3>
                    <p class="text-gray-600 mb-6">
                        Photographie professionnelle pour tous vos besoins : événements, produits, portraits et reportages.
                    </p>
                    <ul class="text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Événements</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Produits</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Portraits</li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-microphone text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Audio & Son</h3>
                    <p class="text-gray-600 mb-6">
                        Enregistrement, mixage et mastering audio. Qualité professionnelle pour vos projets musicaux et audiovisuels.
                    </p>
                    <ul class="text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Enregistrement</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Mixage</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Mastering</li>
                    </ul>
                </div>

                <!-- Service 4 -->
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Événements</h3>
                    <p class="text-gray-600 mb-6">
                        Captation et diffusion d'événements en direct. Mariages, conférences, concerts et plus encore.
                    </p>
                    <ul class="text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Captation</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Diffusion live</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Montage</li>
                    </ul>
                </div>

                <!-- Service 5 -->
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-palette text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Post-Production</h3>
                    <p class="text-gray-600 mb-6">
                        Montage, effets visuels, colorisation et mastering final pour un rendu professionnel.
                    </p>
                    <ul class="text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Montage</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>VFX</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Colorisation</li>
                    </ul>
                </div>

                <!-- Service 6 -->
                <div class="bg-gray-50 p-8 rounded-2xl card-hover">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-lightbulb text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Conseil Créatif</h3>
                    <p class="text-gray-600 mb-6">
                        Accompagnement stratégique et conseils créatifs pour optimiser l'impact de vos projets audiovisuels.
                    </p>
                    <ul class="text-gray-600 space-y-2">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Stratégie</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Conception</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Direction artistique</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Notre Portfolio</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez quelques-uns de nos projets récents qui illustrent notre expertise et notre créativité
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Portfolio Item 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                    <div class="h-64 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-play-circle text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Film Publicitaire</h3>
                        <p class="text-gray-600 mb-4">Campagne publicitaire pour une marque de luxe</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>2024</span>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Item 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                    <div class="h-64 bg-gradient-to-br from-green-400 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-music text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Clip Musical</h3>
                        <p class="text-gray-600 mb-4">Vidéo clip pour un artiste émergent</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>2024</span>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Item 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                    <div class="h-64 bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                        <i class="fas fa-heart text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Mariage</h3>
                        <p class="text-gray-600 mb-4">Film de mariage - Moments inoubliables</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>2024</span>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Item 4 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                    <div class="h-64 bg-gradient-to-br from-yellow-400 to-orange-600 flex items-center justify-center">
                        <i class="fas fa-building text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Vidéo Corporate</h3>
                        <p class="text-gray-600 mb-4">Présentation d'entreprise</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>2024</span>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Item 5 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                    <div class="h-64 bg-gradient-to-br from-red-400 to-pink-600 flex items-center justify-center">
                        <i class="fas fa-microphone text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Concert</h3>
                        <p class="text-gray-600 mb-4">Captation live d'un concert</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>2024</span>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Item 6 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg card-hover">
                    <div class="h-64 bg-gradient-to-br from-indigo-400 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-camera text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Photographie</h3>
                        <p class="text-gray-600 mb-4">Séance photo professionnelle</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>2024</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Prêt à donner vie à votre projet ? Parlons-en !
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">Informations de contact</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Téléphone</h4>
                                <p class="text-gray-600">+33 1 23 45 67 89</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-600">contact@fingerscut.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Adresse</h4>
                                <p class="text-gray-600">123 Rue de la Créativité<br>75001 Paris, France</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Horaires</h4>
                                <p class="text-gray-600">Lun-Ven: 9h-18h<br>Sam: 10h-16h</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="mt-8">
                        <h4 class="font-semibold text-gray-900 mb-4">Suivez-nous</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700 transition duration-300">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700 transition duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition duration-300">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700 transition duration-300">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="bg-gray-50 p-8 rounded-2xl">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">Envoyez-nous un message</h3>
                    
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de projet</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option>Sélectionnez un type</option>
                                <option>Film publicitaire</option>
                                <option>Clip musical</option>
                                <option>Vidéo corporate</option>
                                <option>Événement</option>
                                <option>Photographie</option>
                                <option>Autre</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold text-gradient mb-4">Finger's Cut</h3>
                    <p class="text-gray-400 mb-4">
                        Votre partenaire créatif pour des productions audiovisuelles exceptionnelles.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">Production Vidéo</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Photographie</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Audio & Son</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Événements</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Entreprise</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-300">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Équipe</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Carrières</a></li>
                        <li><a href="#" class="hover:text-white transition duration-300">Blog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>contact@fingerscut.com</li>
                        <li>+33 1 23 45 67 89</li>
                        <li>123 Rue de la Créativité<br>75001 Paris, France</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Finger's Cut. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Connexion</h2>
                <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <button type="button" onclick="closeLoginModal(); openForgotPasswordModal();" class="text-sm text-blue-600 hover:text-blue-800 transition duration-300">
                            Mot de passe oublié ?
                        </button>
                    @endif
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Se connecter
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Pas encore de compte ? 
                    <button onclick="closeLoginModal(); openRegisterModal();" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">
                        S'inscrire
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="registerModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Créer un compte</h2>
                <button onclick="closeRegisterModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf
                
                <!-- Nom et Email en 2 colonnes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="register_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                        <input id="register_name" type="text" name="name" value="{{ old('name') }}" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                               oninput="checkFormValidity()">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="register_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="register_email" type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                               oninput="checkFormValidity()">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Mots de passe en 2 colonnes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <div class="relative">
                            <input id="register_password" type="password" name="password" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                                   oninput="validatePassword()">
                            <button type="button" onclick="togglePasswordVisibility('register_password')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="register_password_eye" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer</label>
                        <div class="relative">
                            <input id="register_password_confirmation" type="password" name="password_confirmation" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                                   oninput="validatePasswordConfirmation()">
                            <button type="button" onclick="togglePasswordVisibility('register_password_confirmation')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="register_password_confirmation_eye" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Indicateurs de validation du mot de passe - Version compacte -->
                <div id="password_requirements" class="grid grid-cols-2 gap-1 text-xs">
                    <div class="flex items-center">
                        <i id="req_length" class="fas fa-times text-red-500 mr-1"></i>
                        <span class="text-gray-600">8+ caractères</span>
                    </div>
                    <div class="flex items-center">
                        <i id="req_uppercase" class="fas fa-times text-red-500 mr-1"></i>
                        <span class="text-gray-600">Majuscule</span>
                    </div>
                    <div class="flex items-center">
                        <i id="req_lowercase" class="fas fa-times text-red-500 mr-1"></i>
                        <span class="text-gray-600">Minuscule</span>
                    </div>
                    <div class="flex items-center">
                        <i id="req_number" class="fas fa-times text-red-500 mr-1"></i>
                        <span class="text-gray-600">Chiffre</span>
                    </div>
                    <div class="flex items-center col-span-2">
                        <i id="req_special" class="fas fa-times text-red-500 mr-1"></i>
                        <span class="text-gray-600">Caractère spécial</span>
                    </div>
                    <div class="flex items-center col-span-2">
                        <i id="password_match_icon" class="fas fa-times text-red-500 mr-1"></i>
                        <span id="password_match_text" class="text-gray-600">Les mots de passe doivent correspondre</span>
                    </div>
                </div>
                
                <div>
                    <label for="register_invitation_code" class="block text-sm font-medium text-gray-700 mb-1">
                        Code d'invitation <span class="text-red-500">*</span>
                    </label>
                    <input id="register_invitation_code" type="text" name="invitation_code" value="{{ old('invitation_code') }}" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                           placeholder="Code fourni par votre administrateur"
                           oninput="checkFormValidity()">
                    <p class="text-xs text-gray-500 mt-1">
                        Contactez votre administrateur pour obtenir un code d'invitation.
                    </p>
                    @error('invitation_code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="register_submit_btn" 
                        class="w-full bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed transition duration-300"
                        disabled>
                    <span id="register_btn_text">Créer le compte</span>
                    <span id="register_btn_loading" class="hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Création...
                    </span>
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Déjà un compte ? 
                    <button onclick="closeRegisterModal(); openLoginModal();" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">
                        Se connecter
                    </button>
                </p>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="forgotPasswordModalContent">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-key mr-2 text-orange-500"></i>
                    Mot de passe oublié
                </h2>
                <button onclick="closeForgotPasswordModal()" class="text-gray-400 hover:text-gray-600 transition duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-orange-100 rounded-full">
                    <i class="fas fa-envelope text-orange-600 text-xl"></i>
                </div>
                <p class="text-sm text-gray-600 text-center">
                    Saisissez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="forgot_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input type="email" 
                           id="forgot_email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           placeholder="votre@email.com"
                           required
                           autofocus>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ session('status') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex space-x-3 pt-2">
                    <button type="button" 
                            onclick="closeForgotPasswordModal()"
                            class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer le lien
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Smooth scrolling script -->
    <script>
        // Enhanced smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);

                    // Calculate offset for fixed navigation
                    const navHeight = document.querySelector('nav').offsetHeight;
                    const targetPosition = target.offsetTop - navHeight - 20; // 20px extra padding

                    // Smooth scroll with easing
                    smoothScrollTo(targetPosition, 1000);
                }
            });
        });

        // Custom smooth scroll function with easing
        function smoothScrollTo(targetPosition, duration) {
            const startPosition = window.pageYOffset;
            const distance = targetPosition - startPosition;
            let startTime = null;

            function animation(currentTime) {
                if (startTime === null) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const run = easeInOutCubic(timeElapsed, startPosition, distance, duration);
                window.scrollTo(0, run);
                if (timeElapsed < duration) requestAnimationFrame(animation);
            }

            // Easing function for smooth animation
            function easeInOutCubic(t, b, c, d) {
                t /= d / 2;
                if (t < 1) return c / 2 * t * t * t + b;
                t -= 2;
                return c / 2 * (t * t * t + 2) + b;
            }

            requestAnimationFrame(animation);
        }

        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-white/95', 'backdrop-blur-sm');
            } else {
                nav.classList.remove('bg-white/95', 'backdrop-blur-sm');
            }

            // Highlight active navigation link
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('nav a[href^="#"]');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 150; // Account for nav height
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('text-blue-600', 'font-semibold');
                link.classList.add('text-gray-700', 'hover:text-blue-600');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.remove('text-gray-700', 'hover:text-blue-600');
                    link.classList.add('text-blue-600', 'font-semibold');
                }
            });
        });

        // Login Modal Functions
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            const modalContent = document.getElementById('modalContent');
            
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

        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            const modalContent = document.getElementById('modalContent');
            
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

        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });

        // Register Modal Functions
        function openRegisterModal() {
            const modal = document.getElementById('registerModal');
            const modalContent = document.getElementById('registerModalContent');
            
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

        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            const modalContent = document.getElementById('registerModalContent');
            
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

        // Close modal when clicking outside
        document.getElementById('registerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });

        // Forgot Password Modal Functions
        function openForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            const modalContent = document.getElementById('forgotPasswordModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger animation
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        function closeForgotPasswordModal() {
            const modal = document.getElementById('forgotPasswordModal');
            const modalContent = document.getElementById('forgotPasswordModalContent');
            
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

        // Close modal when clicking outside
        document.getElementById('forgotPasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeForgotPasswordModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const loginModal = document.getElementById('loginModal');
                const registerModal = document.getElementById('registerModal');
                const forgotPasswordModal = document.getElementById('forgotPasswordModal');
                
                if (!loginModal.classList.contains('hidden')) {
                    closeLoginModal();
                } else if (!registerModal.classList.contains('hidden')) {
                    closeRegisterModal();
                } else if (!forgotPasswordModal.classList.contains('hidden')) {
                    closeForgotPasswordModal();
                }
            }
        });

        // Parallax Balls Animation
        function createParallaxBalls() {
            const container = document.getElementById('parallax-balls');
            const balls = [];
            const ballCount = 12;

            for (let i = 0; i < ballCount; i++) {
                const ball = document.createElement('div');
                const size = Math.random() * 25 + 10; // 10-35px
                const x = Math.random() * 100; // 0-100% of container width
                const y = Math.random() * 100; // 0-100% of container height
                const speed = Math.random() * 0.5 + 0.1; // 0.1-0.6 parallax speed
                const opacity = Math.random() * 0.08 + 0.02; // 0.02-0.1 opacity

                ball.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    background: white;
                    border-radius: 50%;
                    left: ${x}%;
                    top: ${y}%;
                    opacity: ${opacity};
                    pointer-events: none;
                    transition: transform 0.1s ease-out;
                `;

                // Store parallax data
                ball.dataset.speed = speed;
                ball.dataset.initialY = y;

                container.appendChild(ball);
                balls.push(ball);
            }

            // Parallax effect on scroll
            let ticking = false;
            function updateParallax() {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;

                balls.forEach(ball => {
                    const speed = parseFloat(ball.dataset.speed);
                    const initialY = parseFloat(ball.dataset.initialY);
                    const newY = initialY + (rate * speed);
                    
                    ball.style.transform = `translateY(${newY}px)`;
                });

                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick);
        }

        // Password Validation Functions
        function validatePassword() {
            const password = document.getElementById('register_password').value;
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };

            updateRequirementIndicator('req_length', requirements.length);
            updateRequirementIndicator('req_uppercase', requirements.uppercase);
            updateRequirementIndicator('req_lowercase', requirements.lowercase);
            updateRequirementIndicator('req_number', requirements.number);
            updateRequirementIndicator('req_special', requirements.special);

            // Valider la confirmation du mot de passe
            validatePasswordConfirmation();

            const allValid = Object.values(requirements).every(req => req);
            
            const passwordField = document.getElementById('register_password');
            if (allValid) {
                passwordField.classList.remove('border-red-500', 'focus:ring-red-500');
                passwordField.classList.add('border-green-500', 'focus:ring-green-500');
            } else {
                passwordField.classList.remove('border-green-500', 'focus:ring-green-500');
                passwordField.classList.add('border-red-500', 'focus:ring-red-500');
            }

            checkFormValidity();
        }

        function validatePasswordConfirmation() {
            const password = document.getElementById('register_password').value;
            const confirmation = document.getElementById('register_password_confirmation').value;
            const match = password === confirmation && password.length > 0;

            updateRequirementIndicator('password_match_icon', match);
            
            const matchText = document.getElementById('password_match_text');
            if (match) {
                matchText.textContent = 'Les mots de passe correspondent';
                matchText.classList.remove('text-gray-600');
                matchText.classList.add('text-green-600');
            } else {
                matchText.textContent = 'Les mots de passe doivent correspondre';
                matchText.classList.remove('text-green-600');
                matchText.classList.add('text-gray-600');
            }

            const confirmationField = document.getElementById('register_password_confirmation');
            if (match && confirmation.length > 0) {
                confirmationField.classList.remove('border-red-500', 'focus:ring-red-500');
                confirmationField.classList.add('border-green-500', 'focus:ring-green-500');
            } else if (confirmation.length > 0) {
                confirmationField.classList.remove('border-green-500', 'focus:ring-green-500');
                confirmationField.classList.add('border-red-500', 'focus:ring-red-500');
            } else {
                confirmationField.classList.remove('border-red-500', 'focus:ring-red-500', 'border-green-500', 'focus:ring-green-500');
            }

            checkFormValidity();
        }

        function updateRequirementIndicator(elementId, isValid) {
            const icon = document.getElementById(elementId);
            if (isValid) {
                icon.classList.remove('fa-times', 'text-red-500');
                icon.classList.add('fa-check', 'text-green-500');
            } else {
                icon.classList.remove('fa-check', 'text-green-500');
                icon.classList.add('fa-times', 'text-red-500');
            }
        }

        function checkFormValidity() {
            const password = document.getElementById('register_password').value;
            const confirmation = document.getElementById('register_password_confirmation').value;
            const name = document.getElementById('register_name').value;
            const email = document.getElementById('register_email').value;
            const invitationCode = document.getElementById('register_invitation_code').value;

            const passwordValid = password.length >= 8 && 
                                /[A-Z]/.test(password) && 
                                /[a-z]/.test(password) && 
                                /[0-9]/.test(password) && 
                                /[^A-Za-z0-9]/.test(password);

            const passwordsMatch = password === confirmation && password.length > 0;

            const allFieldsFilled = name.length > 0 && email.length > 0 && invitationCode.length > 0;

            // Le formulaire est valide si tous les critères sont remplis
            const formValid = passwordValid && passwordsMatch && allFieldsFilled;

            const submitBtn = document.getElementById('register_submit_btn');
            const btnText = document.getElementById('register_btn_text');
            const btnLoading = document.getElementById('register_btn_loading');

            if (formValid) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-gradient-to-r', 'from-blue-600', 'to-purple-600', 'hover:from-blue-700', 'hover:to-purple-700', 'cursor-pointer');
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-purple-600', 'hover:from-blue-700', 'hover:to-purple-700', 'cursor-pointer');
                submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
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

        // Success Notification Functions
        function showSuccessNotification() {
            const notification = document.getElementById('successNotification');
            if (notification) {
                // Show notification with animation
                setTimeout(() => {
                    notification.classList.remove('translate-x-full', 'opacity-0');
                    notification.classList.add('translate-x-0', 'opacity-100');
                }, 100);
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    hideSuccessNotification();
                }, 5000);
            }
        }

        function hideSuccessNotification() {
            const notification = document.getElementById('successNotification');
            if (notification) {
                notification.classList.remove('translate-x-0', 'opacity-100');
                notification.classList.add('translate-x-full', 'opacity-0');
                
                // Remove from DOM after animation
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }
        }

        // Initialize parallax balls when page loads
        document.addEventListener('DOMContentLoaded', function() {
            createParallaxBalls();
            
            // Show success notification if present
            if (document.getElementById('successNotification')) {
                showSuccessNotification();
            }
        });
    </script>
</body>
</html> 