<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GrupoMateria extends Model
{
    use HasFactory;

    protected $table = 'grupo_materias';

    protected $fillable = [
        'id',
        'grupo_id',
        'materia_id',
        'user_docente_id',
        'contraseña',
        'cantidad_estudiante',
        'cantidad_estudiantes_inscritos',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function userDocente()
    {
        return $this->belongsTo(User::class, 'user_docente_id');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function ingreso()
    {
        return $this->belongsToMany(User::class, 'ingresos', 'grupo_materia_id', 'estudiante_id')->withTimestamps();
    }
    
    public function inscripciones()
    {
        return $this->hasMany(GrupoMateriaBoletaInscripcion::class, 'grupo_materia_id');
    }

    
    public static function getData($data){
        $query = DB::table('grupo_materias')
        ->select('materias.nombre as materia' , 'grupos.nombre as grupo', 'grupo_materias.id')
        ->leftJoin('materias', 'materias.id', '=', 'grupo_materias.materia_id')
        ->leftJoin('grupos', 'grupos.id', '=', 'grupo_materias.grupo_id')
        ->where('grupo_materias.user_docente_id', $data['docente_id']);

        return $query->get();
    }

    public function grupoMateriaBoletaInscripcions()
    {
        return $this->hasMany(GrupoMateriaBoletaInscripcion::class, 'grupo_materia_id');
    }
}
