<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'id',
        'sigla',
        'nombre',
    ];

    public function grupo_materia()
    {
        return $this->belongsTomany(Grupo::class, 'grupo_materias', 'grupo_id', 'materia_id')->withTimestamps();
    }


}
