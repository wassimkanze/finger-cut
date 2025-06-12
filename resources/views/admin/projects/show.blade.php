@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Détails du Projet
            </h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Titre
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->title }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Statut
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->status }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Date de début
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->start_date }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Date de fin
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->end_date }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">
                        Description
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->description }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection 