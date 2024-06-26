<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnomalia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'gravedad',
    ];

    public function anomalias()
    {
        return $this->hasMany(Anomalia::class);
    }
}
