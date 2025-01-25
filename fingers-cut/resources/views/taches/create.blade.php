<?php
@extends('layouts.app')

@section('content')
    <h1>Ajouter une Tâche</h1>
    <form action="{{ route('taches.store') }}" method="POST">
        @csrf
        <label>Nom :</label>
        <input type="text" name="name" required>
        <button type="submit">Créer</button>
    </form>
@endsection
