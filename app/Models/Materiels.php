<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Materiels extends Model
{
    protected $primaryKey = 'Id_materiel';
    protected $fillable = [
    'type_materiel' , 
    'marque' , 
    'modele' , 
    'numero_serie' , 
    'date_acquisition' , 
    'etat'

    ]; 
    
    public function techniciens()
    {
        return $this->belongsToMany(
            Techniciens::class,
            'prendres',       
            'Id_materiel',
            'id_technicien' 
        );
    }
    public function interventions()
    {
        return $this->belongsToMany(
            Interventions::class, 
            'rattachers', 
            'Id_materiel', 
            'id_Intervtion'
        );
    }
}
