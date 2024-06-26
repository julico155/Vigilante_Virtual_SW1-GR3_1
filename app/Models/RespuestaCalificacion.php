<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RespuestaCalificacion extends Pivot
{
    use HasFactory;

    protected $table = 'respuesta_calificacions';

    protected $fillable = [
        'respuesta_id',
        'calificacion_id',
        'pregunta_id',
        'contenido'
    ];

    
}
