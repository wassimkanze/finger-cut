<?php
@extends('layouts.app')

@section('content')
    <h1>Gestion des Utilisateurs</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <ul>
        @foreach($users as $user)
            <li>
                {{ $user->name }} ({{ $user->role->name }})
                <a href="{{ route('users.edit', $user->id) }}">✏️ Modifier</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑️ Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
