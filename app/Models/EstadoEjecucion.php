<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEjecucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function examen()
    {
        return $this->hasMany(Examen::class);
    }

    public function ejecuciones()
    {
        return $this->hasMany(Ejecucion::class);
    }
}
