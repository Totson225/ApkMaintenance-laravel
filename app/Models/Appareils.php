<?php

namespace App\Models;

use App\Models\Demandeurs;
use App\Models\Interventions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appareils extends Model
{
    protected $table='appareils';
    protected $primaryKey = 'id_appareil';
    protected $fillable = [
        'nom_appareil',
        'marque_appareil',
        'type_appareil',
        'etat_appareil',
        'couleur_appareil',
        'id_utilisateur',

    ];

    public function demandeurs():BelongsTo
    {
        return $this->belongsTo(Demandeurs::class, 'id_utilisateur','id_utilisateur');
    }
    public function interventions():HasMany
    {
        return $this->hasMany(Interventions::class, 'id_appareil','id_appareil');
    }
}