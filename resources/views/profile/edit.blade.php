@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-12 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Modifier mon profil</h2>
    @if (session('status'))
        <div class="mb-6 text-green-600 text-center font-semibold">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm py-3 px-4 text-base focus:ring-indigo-500 focus:border-indigo-500">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm py-3 px-4 text-base focus:ring-indigo-500 focus:border-indigo-500">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="pt-4">
            <button type="submit" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-semibold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Mettre à jour
            </button>
        </div>
    </form>

    <hr class="my-10">

    <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Changer mon mot de passe</h3>
    @if (session('password_status'))
        <div class="mb-6 text-green-600 text-center font-semibold">
            {{ session('password_status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
            <input id="current_password" name="current_password" type="password" required autocomplete="current-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm py-3 px-4 text-base focus:ring-indigo-500 focus:border-indigo-500">
            @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm py-3 px-4 text-base focus:ring-indigo-500 focus:border-indigo-500">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm py-3 px-4 text-base focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="pt-4">
            <button type="submit" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-semibold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Changer mon mot de passe
            </button>
        </div>
    </form>
</div>
@endsection
