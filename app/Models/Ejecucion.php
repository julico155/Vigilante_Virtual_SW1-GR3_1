<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ejecucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_final',
        'ponderacion',
        'contrasena',
        'examen_id',
        'nro_preguntas',
        'estado_ejecucion_id',
        'navegacion',
        'retroalimentacion'
    ];

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }

    public function estadoEjecucion()
    {
        return $this->belongsTo(EstadoEjecucion::class);
    }

    public function anomalias()
    {
        return $this->belongsToMany(User::class, 'anomalias', 'ejecucion_id', 'user_id')
                    ->withTimestamps();
    }
    
    public static function getExamenesEjecutandose($data){

        $today = Carbon::now()->format('Y-m-d');

        $query = DB::table('ejecucions');
        if(isset($data['min'])
        && $data['min'] === 1){
                $query->select(DB::raw('COUNT(ejecucions.id) as total'));
            }
        else{
            //Logica cuando se requiera datos mas informacion, por ahora no
        }

        $query->leftJoin('examens', 'examens.id', 'ejecucions.examen_id')
        ->whereIn('estado_ejecucion_id', [1,3]);

        if(isset($data['user_id'])
        && $data['user_id'] != ''){
            $query->where('examens.user_id', $data['user_id']);
        }

        return $query->get();
    }

    public function estudiantes(){
        return $this->belongsToMany(User::class, 'calificacions', 'user_id', 'ejecucion_id')->withTimestamps();

    }

    public static function getData($data){
        $query = DB::table('ejecucions')
        ->select('examens.tema', 'ejecucions.*', 'estado_ejecucions.nombre as estado_ejecucion')
            ->leftJoin('examens', 'examens.id', '=','ejecucions.examen_id')
            ->leftJoin('estado_ejecucions', 'estado_ejecucions.id', '=','ejecucions.estado_ejecucion_id')
            ->where('examens.grupo_materia_id', $data['grupo_materia_id']);
            
        

        return $query->get();
    }
}
