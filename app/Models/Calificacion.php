<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class Calificacion extends Model
{
    use HasFactory;
    protected $table = 'calificacions';

    // protected $fillable = [
    //     'user_id',
    //     'ejecucion_id',
    //     'comentario',
    // ];

    public function preguntas(){
        return $this->belongsToMany(Pregunta::class, 'respueta_calificacions', 'calificacion_id', 'respuesta_id')->withTimestamps();
    }

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    public function ejecucion(){
        return $this->belongsTo(Ejecucion::class);
    }
}
