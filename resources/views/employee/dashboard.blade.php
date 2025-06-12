@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Bienvenue sur votre tableau de bord</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('employee.projects') }}" class="p-4 bg-indigo-100 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800">Projets</h3>
                <p class="text-sm text-gray-600">{{ $assignedProjectsCount }}/{{ $totalProjectsCount }} vous sont assignés</p>
            </a>
        </div>
    </div>
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h2 class="text-lg font-semibold mb-4">Utilisateurs</h2>
        <ul class="divide-y divide-gray-200">
            @foreach($users as $user)
                <li class="py-2 flex justify-between items-center">
                    <span>{{ $user->name }}</span>
                    @if(!$user->disabled)
                        <a href="mailto:{{ $user->email }}" class="text-sm text-indigo-600 hover:underline">Contacter</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection 