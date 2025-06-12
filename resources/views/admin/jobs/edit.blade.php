@extends('layouts.app')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-2xl mx-auto mt-4" role="alert">
        <strong class="font-bold">Erreurs :</strong>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Modifier l'offre d'emploi</h1>
    <form method="POST" action="{{ route('admin.jobs.update', $job) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title', $job->title) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('description', $job->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="is_active" class="block text-sm font-medium text-gray-700">Statut de l'offre</label>
            <select name="is_active" id="is_active" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                <option value="1" {{ old('is_active', $job->is_active) ? 'selected' : '' }}>Ouverte</option>
                <option value="0" {{ !old('is_active', $job->is_active) ? 'selected' : '' }}>Clôturée</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $job->start_date) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $job->end_date) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="contract_type" class="block text-sm font-medium text-gray-700">Type de contrat</label>
            <input type="text" name="contract_type" id="contract_type" value="{{ old('contract_type', $job->contract_type) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection 