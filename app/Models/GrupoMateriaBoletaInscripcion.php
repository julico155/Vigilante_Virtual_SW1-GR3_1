<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoMateriaBoletaInscripcion extends Model
{
    use HasFactory;

    protected $table = 'grupo_materia_boleta_inscripcions';

    protected $fillable = [
        'boleta_inscripcion_id',
        'grupo_materia_id',
    ];

    public function grupo_materia()
    {
        return $this->belongsTo(GrupoMateria::class);
    }

    public function boleta_inscripcion()
    {
        return $this->belongsTo(BoletaInscripcion::class);
    }
}
