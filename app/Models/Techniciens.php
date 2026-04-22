<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Techniciens extends Model
{
    protected $table='techniciens';
    protected $primaryKey = 'id_technicien';
    protected $fillable = [
        'nom_techniciens',
        'prenom_techniciens',
        'telephone_technicien',
        'sexe_techniciens',
        'specialite_technicien',
        'email_technicien',
        'statut_tech',

    ];

    public function interventions()
    {
        return $this->belongsToMany(
            Interventions::class,
            'concerners',                
             'id_technicien',
            'id_Intervtion' 
        );
    }

    public function materiels()
    {
        return $this->belongsToMany(
            Materiels::class,
            'prendres',       
            'id_technicien',
            'Id_materiel'
        );
    }
}
