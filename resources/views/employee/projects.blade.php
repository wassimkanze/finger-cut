@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Liste des projets</h2>
        <div class="flex items-center justify-between mb-4">
            <label for="project-filter" class="block text-sm font-medium text-gray-700">Filtrer les projets</label>
            <select id="project-filter" name="filter" class="block w-48 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="location = this.value;">
                <option value="?filter=all" {{ request('filter') === 'all' ? 'selected' : '' }}>Tous les projets</option>
                <option value="?filter=assigned" {{ request('filter') === 'assigned' ? 'selected' : '' }}>Projets assignés</option>
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($projects as $project)
                @if($project->employees->contains(Auth::user()))
                    <a href="{{ route('employee.projects.show', $project->id) }}" class="bg-white p-6 rounded shadow block">
                        <h3 class="font-bold text-lg">{{ $project->title }}</h3>
                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Assigné</span>
                    </a>
                @else
                    <div class="bg-white p-6 rounded shadow text-gray-400 cursor-not-allowed">
                        <h3 class="font-bold text-lg">{{ $project->title }}</h3>
                    </div>
                @endif
            @empty
                <p class="text-center text-gray-500 col-span-full">Aucun projet trouvé.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection 