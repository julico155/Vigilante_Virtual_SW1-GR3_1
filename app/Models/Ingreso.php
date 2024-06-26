<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';

    protected $fillable  = [
        'grupo_materia_id',
        'estudiante_id',
        'fecha_ingreso',
    ];

    public function grupo_materia()
    {
        return $this->belongsTo(GrupoMateria::class, 'grupo_materia_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

}
