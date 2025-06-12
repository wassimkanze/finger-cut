@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Créer un Nouveau Créneau
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.planning.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700">Projet</label>
                        <select name="project_id" id="project_id" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" id="date" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Heure de début</label>
                        <input type="time" name="start_time" id="start_time" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">Heure de fin</label>
                        <input type="time" name="end_time" id="end_time" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="location" class="block text-sm font-medium text-gray-700">Lieu</label>
                        <input type="text" name="location" id="location" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 