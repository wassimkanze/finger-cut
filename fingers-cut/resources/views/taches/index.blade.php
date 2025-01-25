<?php
@extends('layouts.app')

@section('content')
    <h1>Liste des Tâches</h1>
    <a href="{{ route('taches.create') }}">➕ Ajouter une tâche</a>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <ul>
        @foreach($taches as $tache)
            <li>
                {{ $tache->name }}
                <a href="{{ route('taches.edit', $tache->id) }}">✏️ Modifier</a>
                <form action="{{ route('taches.destroy', $tache->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑️ Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
