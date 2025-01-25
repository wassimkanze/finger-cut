<?php
@extends('layouts.app')

@section('content')
    <h1>Modifier la Tâche</h1>
    <form action="{{ route('taches.update', $tache->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nom :</label>
        <input type="text" name="name" value="{{ $tache->name }}" required>
        <button type="submit">Mettre à jour</button>
    </form>
@endsection
