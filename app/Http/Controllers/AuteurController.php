<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuteurController extends Controller
{
    public function index () {
        $auteurs = DB::table('auteurs')->get();
        return view('auteurs.index', compact('auteurs'));
    }
    public function create() {
        return view ('auteurs.create');
    }
    public function store (Request $request )
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'biographie' => 'nullable|string',
        ]);
        DB::table('auteurs')->insert($request->all());
        return redirect()->route('auteurs.index');
    }
    public function edit ($id) {
        $auteur = DB::table('auteurs')->find($id);
        return view ('auteurs.edit', compact('auteur'));
    
}
    public function update (Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'biographie' => 'nullable|string',
        ]);
        DB::table('auteurs')->where('id', $id)->update($request->all());
        return redirect()->route('auteurs.index');
    }
    public function destroy ($id) {
        DB::table('auteurs')->where('id', $id)->delete();
        return redirect()->route('auteurs.index');
    }
    public function show ($id) {
        $auteur = DB::table('auteurs')->find($id);
        return view ('auteurs.show', compact('auteur'));
    }
}
