<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;

    protected $table = 'gestions';

    protected $fillable = [
        'id',
        'nombre',
        'fecha_inicio',
        'fecha_final',
    ];

    public function grupo_materia()
    {
        return $this->hasMany(GrupoMateria::class);
    }

}
