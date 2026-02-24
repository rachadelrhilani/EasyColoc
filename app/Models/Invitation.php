<?php

namespace App\Models;

use Dotenv\Util\Str as UtilStr;
use Illuminate\Database\Eloquent\Model;
use Psy\Util\Str;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'statut',
        'date_expiration',
        'colocation_id'
    ];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function genererToken()
    {
        $this->token = str()::random(40);
        $this->save();
    }

    public function verifierValidite()
    {
        return $this->statut === 'en_attente' &&
               $this->date_expiration > now();
    }
}
