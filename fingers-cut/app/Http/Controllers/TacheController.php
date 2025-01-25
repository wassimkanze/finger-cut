<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::all();
        return view('taches.index', compact('taches'));
    }

    public function create()
    {
        return view('taches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Tache::create([
            'name' => $request->name,
        ]);

        return redirect()->route('taches.index')->with('success', 'Tâche créée avec succès.');
    }

    public function show(Tache $tache)
    {
        return view('taches.show', compact('tache'));
    }

    public function edit(Tache $tache)
    {
        return view('taches.edit', compact('tache'));
    }

    public function update(Request $request, Tache $tache)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tache->update([
            'name' => $request->name,
        ]);

        return redirect()->route('taches.index')->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Tache $tache)
    {
        $tache->delete();
        return redirect()->route('taches.index')->with('success', 'Tâche supprimée.');
    }
}
