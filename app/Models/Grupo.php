<?php

namespace App\Models;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'nombre',
    ];

    public function grupo_materia()
    {
        return $this->belongsTomany(Materia::class, 'grupo_materias', 'grupo_id', 'materia_id')->withTimestamps();
    }

    public function grupo_materia_boleta_inscripcions()
    {
        return $this->belongsToMany(GrupoMateriaBoletaInscripcion::class, 'grupo_materia_boleta_inscripcions', 'boleta_inscripcion_id', 'grupo_materia_id')->withTimestamps();
    }

}
