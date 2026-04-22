<?php

namespace App\Models;

use App\Models\Appareils;
use App\Models\Demandeurs;
use App\Models\PieceRechanges;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interventions extends Model
{
    protected $table='interventions';
    protected $primaryKey='id_Intervtion';
    protected $fillable=[
        'date_demande',
        'date_intervention',
        'descript_panne',
        'solution_apportee',
        'type_intervention',
        'id_appareil',
        'id_utilisateur',
    ];

    public function demandeurs():BelongsTo
    {
        return $this->belongsTo(Demandeurs::class, 'id_utilisateur','id_utilisateur');
    }
    public function appareils():BelongsTo
    {
        return $this->belongsTo(Appareils::class, 'id_appareil','id_appareil');
    }

        public function pieces():HasMany
    {
        return $this->hasMany(PieceRechanges::class, 'id_Intervtion','id_Intervtion');
    }
    public function techniciens()
    {
        return $this->belongsToMany(
            Techniciens::class, 
            'concerners',                 
            'id_Intervtion',
            'id_technicien' 
        );
    }
    public function materiels()
    {
        return $this->belongsToMany(
            Materiels::class, 
            'rattachers', 
            'id_Intervtion', 
            'Id_materiel'
        )->withPivot('Deb_intervention');
    }
}
