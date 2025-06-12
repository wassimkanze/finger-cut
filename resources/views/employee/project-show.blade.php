@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">{{ $project->title }}</h2>
        <div class="grid grid-cols-1 gap-4">
            @forelse($planningSlots as $slot)
                <div class="bg-white shadow rounded p-4">
                    <p><strong>Date:</strong> {{ $slot->date }}</p>
                    <p><strong>Heure de début:</strong> {{ $slot->start_time }}</p>
                    <p><strong>Heure de fin:</strong> {{ $slot->end_time }}</p>
                    <p><strong>Lieu:</strong> {{ $slot->location }}</p>
                </div>
            @empty
                <p class="text-center text-gray-500">Aucun créneau pour ce projet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection 