<?php

namespace App\Models;

use App\Models\Interventions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceRechanges extends Model
{
    protected $table='piece_rechanges';
    protected $primaryKey = 'id_PRechange';
    protected $fillable = [
        'Nom',
        'Marque',
        'Prix',
        'Stock',
        'id_Intervtion',
    ];

    public function interventions():BelongsTo
    {
        return $this->belongsTo(Interventions::class, 'id_Intervtion','id_Intervtion');
    }
}
