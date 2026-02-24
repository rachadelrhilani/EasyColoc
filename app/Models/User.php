<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'email',
        'password',
        'role', // owner | membre | admin
        'reputation',
        'statut', // actif | quitte
        'date_adhesion',
        'date_depart',
        'colocation_id',
        'est_actif'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function estAdmin()
    {
        return $this->role === 'admin';
    }

    public function estBanni()
    {
        return !$this->est_actif;
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function depensesPayees()
    {
        return $this->hasMany(Depense::class, 'payeur_id');
    }

    public function paiementsEffectues()
    {
        return $this->hasMany(Paiement::class, 'payeur_id');
    }

    public function paiementsRecus()
    {
        return $this->hasMany(Paiement::class, 'receveur_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
