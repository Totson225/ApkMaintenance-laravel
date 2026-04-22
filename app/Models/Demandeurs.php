<?php

namespace App\Models;

use App\Models\Appareils;
use App\Models\Interventions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demandeurs extends Model
{
    protected $table='demandeurs';
    protected $primaryKey = 'id_utilisateur';
    protected $fillable = [
        'nom_demandeur',
        'prenom_demandeur',
        'telephone_demandeur',
        'sexe_demandeurs',
        'service_demandeur',
        'email_demandeur',

    ];

    public function appareils():HasMany
       {  
         return $this->hasMany(Appareils::class, 'id_utilisateur','id_utilisateur');
       }

    public function interventions():HasMany
    {
        return $this->hasMany(Interventions::class, 'id_utilisateur','id_utilisateur' );
    }
}


