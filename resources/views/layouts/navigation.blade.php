<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<nav x-data="{ open: false }" class="bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <div class="flex items-center space-x-8">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-8 w-auto">
            </a>
            <a href="{{ route('welcome') }}#about" class="hover:text-indigo-400 transition">À propos</a>
            <a href="{{ route('welcome') }}#gallery" class="hover:text-indigo-400 transition">Galerie</a>
            <a href="{{ route('welcome') }}#recruitment" class="hover:text-indigo-400 transition">Recrutement</a>
            <a href="{{ route('welcome') }}#contact" class="hover:text-indigo-400 transition">Contact</a>
        </div>
        
        <div class="flex items-center space-x-4">
            @guest
                <a href="{{ route('login') }}" class="hover:text-indigo-400 transition">Connexion</a>
            @else
                <div class="flex items-center space-x-2 relative z-30">
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-navbar">
                        @csrf
                        <button type="button" class="px-3 py-2 rounded hover:text-indigo-400 transition focus:outline-none focus:ring focus:ring-indigo-300 text-white" onclick="console.log('logout'); document.getElementById('logout-form-navbar').submit();">Déconnexion</button>
                    </form>
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('employee.dashboard') }}" class="px-3 py-2 rounded hover:text-indigo-400 transition focus:outline-none focus:ring focus:ring-indigo-300 text-white">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="px-3 py-2 rounded hover:text-indigo-400 transition focus:outline-none focus:ring focus:ring-indigo-300 text-white">Profil</a>
                </div>
            @endguest
        </div>
    </div>
</nav>