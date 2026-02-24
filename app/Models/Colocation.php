<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'statut'
    ];

    public function membres()
    {
        return $this->hasMany(User::class);
    }

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
