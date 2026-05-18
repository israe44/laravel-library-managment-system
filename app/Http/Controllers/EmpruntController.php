<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use Illuminate\Http\Request;

class EmpruntController extends Controller
{
   public function index () {
    $emprunts = Emprunt::all(); 
    return view('emprunts.index', compact('emprunts'));
   }
   public function create() {
    return view ('emprunts.create');
   }
   public function store (Request $request ) 
   {
    $request->validate([
        'adherent_id' => 'required|exists:adherents,id',
        'livre_id' => 'required|exists:livres,id',
        'date_emprunt' => 'required|date',
        'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
    ]);
    $emprunt = Emprunt::create($request->all());
    return redirect()->route('emprunts.index');
   }
   public function update (Request $request, Emprunt $emprunt)
   {
    $request->validate([
        'adherent_id' => 'required|exists:adherents,id',
        'livre_id' => 'required|exists:livres,id',
        'date_emprunt' => 'required|date',
        'date_retour_prevue' => 'required|date|after_or_equal:date_emprunt',
        'date_retour_reelle' => 'nullable|date|after_or_equal:date_emprunt',
        'statut' => 'required|string',
    ]);
    $emprunt->update($request->all());
    return redirect()->route('emprunts.index');
   }
   public function edit (Emprunt $emprunt) {
    return view ('emprunt.edit', compact('emprunt'));
   }
   public function destroy (Emprunt $emprunt) {
    $emprunt->delete();
    return redirect()->route('emprunts.index');
   }
   public function show (Emprunt $emprunt) {
    return view ('emprunt.show', compact('emprunt'));
   }
}
