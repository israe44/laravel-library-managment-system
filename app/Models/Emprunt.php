<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    protected $fillable = ['adherent_id', 'livre_id', 'date_emprunt', 'date_retour_prevue', 'date_retour_reelle', 'statut'];
    public function adherent() {
        return $this->belongsTo(Adherent::class);
    }
    public function livre() {
        return $this->belongsTo(Livre::class);
    }
}
