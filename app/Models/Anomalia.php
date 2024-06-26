<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anomalia extends Model
{
    use HasFactory;

    protected $fillable = [
        'ejecucion_id',
        'user_id',
        'hora',
        'fecha',
        'url_imagen',
        'tipo_anomalia_id',
    ];

    public function tipoAnomalia()
    {
        return $this->belongsTo(TipoAnomalia::class);
    }

    public function ejecucion()
    {
        return $this->belongsTo(Ejecucion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
