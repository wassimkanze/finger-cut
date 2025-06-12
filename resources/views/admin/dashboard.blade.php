@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Bonjour, {{ auth()->user()->name }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Voici un aperçu de vos statistiques et actions rapides.
            </p>
        </div>
    </div>

    <!-- Statistics Section -->
<div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <a href="{{ route('admin.users.index') }}" class="bg-white overflow-hidden shadow rounded-lg p-5 hover:bg-gray-50">
        <div class="text-sm font-medium text-gray-500 truncate">
            Gestion des utilisateurs
        </div>
        <div class="mt-1 text-3xl font-semibold text-gray-900">
            {{ $users_count }}
        </div>
    </a>

    <a href="{{ route('admin.projects.index') }}" class="block">
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Nombre de projets
                </div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ $projects_count }}
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.jobs.index') }}" class="block">
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Nombre d'offres d'emploi actives
                </div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ $jobs_count }}
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.planning.index') }}" class="block">
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Nombre d'éléments dans le planning
                </div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ $planning_count }}
                </div>
            </div>
        </div>
    </a>
</div>

    <!-- Quick Actions Section -->
    <div class="mt-10">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Actions rapides
        </h3>
        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('admin.projects.create') }}" class="bg-white overflow-hidden shadow rounded-lg p-5 hover:bg-gray-50">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Créer un nouveau projet
                </div>
            </a>

            <a href="{{ route('admin.jobs.create') }}" class="bg-white overflow-hidden shadow rounded-lg p-5 hover:bg-gray-50">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Créer une offre d'emploi
                </div>
            </a>

            <a href="{{ route('admin.planning.create') }}" class="bg-white overflow-hidden shadow rounded-lg p-5 hover:bg-gray-50">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Créer un créneau de planning
                </div>
            </a>

            <a href="{{ route('admin.users.create') }}" class="bg-white overflow-hidden shadow rounded-lg p-5 hover:bg-gray-50">
                <div class="text-sm font-medium text-gray-500 truncate">
                    Créer un utilisateur
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 