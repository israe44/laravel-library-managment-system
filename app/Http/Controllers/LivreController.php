<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{


public function index() {
    $livres = DB::select('SELECT * FROM livres');
    return view('livres.index', compact('livres'));
}

public function create() {
    $categories = DB::select('SELECT id, nom FROM categories');
    return view('livres.create', compact('categories'));
}

public function store(Request $request) {
    $request->validate([
        'titre' => 'required|string|max:255',
        'isbn' => 'required|string|unique:livres',
        'annee' => 'required|integer',
        'stock' => 'required|integer',
        'categorie_id' => 'required|exists:categories,id',
    ]);
    
    DB::insert('INSERT INTO livres (titre, isbn, annee, stock, categorie_id, created_at, updated_at) 
               VALUES (?, ?, ?, ?, ?, ?, ?)', [
        $request->titre,
        $request->isbn,
        $request->annee,
        $request->stock,
        $request->categorie_id,
        now(),
        now(),
    ]);
    
    return redirect()->route('livres.index')->with('success', 'Livre créé');
}

public function show($id) {
    $livre = DB::selectOne('SELECT * FROM livres WHERE id = ?', [$id]);
    if (!$livre) abort(404);
    return view('livres.show', compact('livre'));
}

public function edit($id) {
    $livre = DB::selectOne('SELECT * FROM livres WHERE id = ?', [$id]);
    $categories = DB::select('SELECT id, nom FROM categories');
    if (!$livre) abort(404);
    return view('livres.edit', compact('livre', 'categories'));
}

public function update(Request $request, $id) {
    $request->validate([
        'titre' => 'required|string|max:255',
        'isbn' => 'required|string|unique:livres,isbn,' . $id,
        'annee' => 'required|integer',
        'stock' => 'required|integer',
        'categorie_id' => 'required|exists:categories,id',
    ]);
    
    DB::update('UPDATE livres SET titre = ?, isbn = ?, annee = ?, stock = ?, categorie_id = ?, updated_at = ? 
                WHERE id = ?', [
        $request->titre,
        $request->isbn,
        $request->annee,
        $request->stock,
        $request->categorie_id,
        now(),
        $id,
    ]);
    
    return redirect()->route('livres.index')->with('success', 'Livre mis à jour');
}

public function destroy($id) {
    DB::delete('DELETE FROM livres WHERE id = ?', [$id]);
    return redirect()->route('livres.index')->with('success', 'Livre supprimé');
} }
