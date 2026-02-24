<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'payeur_id',
        'receveur_id',
        'montant',
        'colocation_id'
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function payeur()
    {
        return $this->belongsTo(User::class, 'payeur_id');
    }

    public function receveur()
    {
        return $this->belongsTo(User::class, 'receveur_id');
    }
}
