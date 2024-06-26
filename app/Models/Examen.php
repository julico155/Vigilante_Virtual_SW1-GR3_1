<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable = [
        'tema',
        'descripcion',
        'user_id',
        'grupo_materia_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ejecuciones()
    {
        return $this->hasMany(Ejecucion::class);
    }


    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }

    public function grupoMateria()
    {
        return $this->belongsTo(GrupoMateria::class, 'grupo_materia_id');
    }
}
