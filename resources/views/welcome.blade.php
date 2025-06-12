@extends('layouts.app')

@section('content')
<section class="relative bg-cover bg-center bg-no-repeat py-32" style="background-image: url('/images/hero-fingerscut.jpg');">
    <div class="bg-black bg-opacity-50 absolute inset-0"></div>
    <div class="relative max-w-4xl mx-auto text-center text-white z-10">
        <h1 class="text-5xl font-bold">
            Bienvenue chez <span class="text-indigo-400">Finger's Cut</span>
        </h1>
        <p class="mt-6 text-lg">
            L'excellence visuelle au service de vos projets.</br>
            Captation, réalisation, postproduction : notre équipe transforme vos idées en images marquantes.
        </p>
    </div>
</section>

<!-- About Section -->
<section id="about" class="bg-gray-100 py-24">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-gray-900">À propos de Finger's Cut</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                Spécialistes de la production audiovisuelle, nous capturons vos instants précieux avec maîtrise technique et sens artistique.
            </p>
        </div>
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="flex flex-col items-center text-center">
                <svg class="h-16 w-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 10.5V6.75A2.25 2.25 0 0013.5 4.5h-3A2.25 2.25 0 008.25 6.75v3.75m7.5 0h1.5a2.25 2.25 0 012.25 2.25v4.5a2.25 2.25 0 01-2.25 2.25h-1.5m-7.5-9H6.75A2.25 2.25 0 004.5 12.75v4.5A2.25 2.25 0 006.75 19.5H9m6.75-9v9m-7.5-9v9" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">Vidéo</h3>
                <p class="mt-2 text-sm text-gray-500">Captation et montage pour tous vos projets.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <svg class="h-16 w-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18.75a6.75 6.75 0 006.75-6.75V7.5a6.75 6.75 0 00-13.5 0v4.5A6.75 6.75 0 0012 18.75z" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">Son</h3>
                <p class="mt-2 text-sm text-gray-500">Enregistrement clair et mixage professionnel.</p>
            </div>
            <div class="flex flex-col items-center text-center">
                <svg class="h-16 w-16 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2m6.364 1.636l-1.414 1.414M21 12h-2M6.364 5.636l1.414 1.414M3 12h2m12.364 6.364l-1.414-1.414M12 21v-2m-6.364-1.636l1.414-1.414" />
                </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900">Éclairage</h3>
                <p class="mt-2 text-sm text-gray-500">Ambiances lumineuses adaptées à chaque scène.</p>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-gray-900">Galerie</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                Découvrez nos projets audiovisuels variés et inspirants.
            </p>
        </div>
        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $projects = [
                    ['name' => 'Clip musical', 'image' => 'clip.jpg'],
                    ['name' => 'Documentaire', 'image' => 'doc.jpg'],
                    ['name' => 'Publicité', 'image' => 'pub.jpg'],
                    ['name' => 'Film court', 'image' => 'film.jpg'],
                    ['name' => 'Interview', 'image' => 'interview.jpg'],
                    ['name' => 'Événement', 'image' => 'event.jpg'],
                ];
            @endphp

            @foreach($projects as $project)
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <img src="{{ asset('images/gallery/' . $project['image']) }}" alt="{{ $project['name'] }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $project['name'] }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Une brève description de notre projet {{ strtolower($project['name']) }}.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Recruitment Section -->
<section id="recruitment" class="relative py-24" style="background-image: url('/images/bg-recrutement.jpg'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-4xl font-bold text-white">Recrutement</h2>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-200">
                Découvrez nos offres d'emploi actuelles.
            </p>
        </div>
        <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse($jobs as $job)
            <div class="bg-white bg-opacity-90 rounded-lg shadow-md hover:shadow-lg transition p-6 flex flex-col h-full animate-fade-in">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="h-7 w-7 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6.75V5.25A2.25 2.25 0 0014.25 3h-4.5A2.25 2.25 0 007.5 5.25v1.5M3.75 9A2.25 2.25 0 016 6.75h12A2.25 2.25 0 0120.25 9v8.25A2.25 2.25 0 0118 19.5H6A2.25 2.25 0 013.75 17.25V9z" /></svg>
                    <h3 class="text-xl font-semibold text-indigo-700">{{ $job->title }}</h3>
                </div>
                <div class="text-sm text-gray-600 mb-2 max-h-20 overflow-hidden">{{ $job->description }}</div>
                <div class="flex items-center text-xs text-gray-400 mb-2 gap-2">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75V5.25A2.25 2.25 0 0110.5 3h3A2.25 2.25 0 0115.75 5.25v1.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9A2.25 2.25 0 016 6.75h12A2.25 2.25 0 0120.25 9v8.25A2.25 2.25 0 0118 19.5H6A2.25 2.25 0 013.75 17.25V9z" /></svg>
                    <span>Type de contrat: {{ $job->contract_type }}</span>
                </div>
                <div class="flex items-center text-xs text-gray-400 mb-4 gap-2">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /><circle cx="12" cy="12" r="9" /></svg>
                    <span>
                        Publié le:
                        @if($job->published_at)
                            {{ $job->published_at->format('d/m/Y') }}
                        @else
                            <span class="italic text-gray-400">Date inconnue</span>
                        @endif
                    </span>
                </div>
                <div class="mt-auto pt-2">
                    <a href="#contact" class="inline-block w-full text-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 transition">Postuler</a>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-200">Aucune offre d'emploi active pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="min-h-screen flex items-center justify-center bg-[url('/images/bg-contact-texture.png')] bg-cover bg-center bg-fixed bg-gray-100 py-24">
    <div class="w-full">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-10 flex flex-col items-center">
            <div class="flex flex-col items-center mb-6">
                <svg class="h-10 w-10 text-indigo-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75m19.5 0v.243a2.25 2.25 0 01-.659 1.591l-7.5 7.5a2.25 2.25 0 01-3.182 0l-7.5-7.5A2.25 2.25 0 012.25 6.993V6.75" /></svg>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Contact</h2>
                <p class="mt-2 text-lg text-gray-500 text-center max-w-xl">Nous serions ravis de vous entendre. Envoyez-nous un message !</p>
            </div>
            @if(session('status'))
                <div class="mb-4 text-green-600 text-center font-semibold">
                    {{ session('status') }}
                </div>
            @endif
            <form class="w-full space-y-6" method="POST" action="{{ route('contact.send') }}">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full py-3 px-4 text-base shadow-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full py-3 px-4 text-base shadow-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
                    <input type="text" name="subject" id="subject" required class="mt-1 block w-full py-3 px-4 text-base shadow-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="message" name="message" rows="4" required class="mt-1 block w-full py-3 px-4 text-base shadow-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-semibold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        document.getElementById('confirmation-message').classList.remove('hidden');
    });
</script>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 1s cubic-bezier(0.4,0,0.2,1) both;
}
</style>

<!-- Footer -->
<footer class="bg-black text-gray-300 mt-24">
    <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center md:items-start justify-between gap-8">
        <!-- Logo/Nom -->
        <div class="flex items-center space-x-3 mb-6 md:mb-0">
            <img src="/images/logo.jpg" alt="Finger's Cut Logo" class="h-10 w-10 rounded-full hidden sm:block">
            <span class="text-2xl font-bold tracking-tight">Finger's Cut</span>
        </div>
        <!-- Navigation -->
        <nav class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-8 text-base">
            <a href="#about" class="hover:text-white transition">À propos</a>
            <a href="#gallery" class="hover:text-white transition">Galerie</a>
            <a href="#recruitment" class="hover:text-white transition">Recrutement</a>
            <a href="#contact" class="hover:text-white transition">Contact</a>
        </nav>
        <!-- Réseaux sociaux -->
        <div class="flex space-x-6 mt-6 md:mt-0">
            <a href="https://www.instagram.com/fingers_cut" target="_blank" aria-label="Instagram" class="hover:text-white transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" stroke="currentColor"/><circle cx="12" cy="12" r="5" stroke="currentColor"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/></svg>
            </a>
            <a href="https://www.youtube.com/@FingersCut." target="_blank" aria-label="YouTube" class="hover:text-white transition">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="4" stroke="currentColor"/><path d="M10 9.5v5l4.5-2.5L10 9.5z" fill="currentColor"/></svg>
            </a>
        </div>
    </div>
    <div class="bg-black text-center text-sm py-4 mt-6 flex flex-col md:flex-row items-center justify-between">
        <span>© 2025 Finger's Cut. Tous droits réservés.</span>
        <a href="{{ route('legal') }}" class="mt-2 md:mt-0 md:ml-4 text-gray-400 hover:text-white transition underline">Mentions légales</a>
    </div>
</footer>
@endsection
