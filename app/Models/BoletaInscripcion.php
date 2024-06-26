<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoletaInscripcion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_estudiante_id',
        'user_administrativo_id',
        'hora',
        'fecha',
        'cantidad_materias_inscritas',
    ];

    public function user_estudiante()
    {
        return $this->belongsTo(User::class, 'user_estudiante_id');
    }

    public function user_administrativo()
    {
        return $this->belongsTo(User::class, 'user_administrativo_id');
    }

    public function grupo_materia_boleta_inscripcion()
    {
        return $this->hasMany(GrupoMateriaBoletaInscripcion::class, 'boleta_inscripcion_id');
    }
    public function grupo_materia_boleta_inscripcions()
    {
        return $this->hasMany(GrupoMateriaBoletaInscripcion::class, 'boleta_inscripcion_id');
    }

}
