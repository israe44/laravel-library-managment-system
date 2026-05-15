<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    protected $fillable = ['nom', 'prenom', 'nationalite'];
    public function livres() {
        return $this->belongsToMany(Livre::class, 'livre_auteur', 'auteur_id', 'livre_id');
    }
}
