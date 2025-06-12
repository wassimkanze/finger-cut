@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Modifier le Projet
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" id="title" value="{{ $project->title }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" id="status" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <option value="en attente" {{ $project->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en cours" {{ $project->status == 'en cours' ? 'selected' : '' }}>En cours</option>
                            <option value="terminé" {{ $project->status == 'terminé' ? 'selected' : '' }}>Terminé</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $project->start_date }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $project->end_date }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $project->description }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
    <label for="employees" class="block text-sm font-medium text-gray-700">Assigner des employés</label>
    <select name="employees[]" id="employees" multiple class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}" {{ $project->employees->contains($employee->id) ? 'selected' : '' }}>
                {{ $employee->name }}
            </option>
        @endforeach
    </select>
</div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 