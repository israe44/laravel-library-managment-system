<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;

class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adherents = Adherent::all();
        return view('adherents.index', compact('adherents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adherents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email',
            'telephone' => 'nullable|string|max:20',
        ]);
        Adherent::create($request->validated());
        return redirect()->route('adherents.index')->with('success', 'Adhérent créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adherent $adherent)
    {
        return view('adherents.show', compact('adherent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adherent $adherent)
    {
        return view('adherents.edit', compact('adherent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adherent $adherent)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email,' . $adherent->id,
            'telephone' => 'nullable|string|max:20',
        ]);
        $adherent->update($request->validated());
        return redirect()->route('adherents.index')->with('success', 'Adhérent mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adherent $adherent)
    {
        $adherent->delete();
        return redirect()->route('adherents.index')->with('success', 'Adhérent supprimé avec succès');
    }
}
