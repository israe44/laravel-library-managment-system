<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    protected $fillable = ['titre', 'isbn', 'annee', 'stock', 'categorie_id'];
    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }
    public function emprunts() {
        return $this->hasMany(Emprunt::class);
    }
    public function auteurs() {
        return $this->belongsToMany(Auteur::class, 'livre_auteur', 'livre_id', 'auteur_id');
    }
    
}
