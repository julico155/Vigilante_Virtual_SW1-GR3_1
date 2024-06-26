<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    protected $table = 'comprobantes';

    protected $fillable = [
        'user_estudiante_id',
        'user_administrativo_id',
        'hora',
        'fecha',
        'monto_total',
    ];


    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_comprobantes', 'comprobante_id', 'servicio_id')->withTimestamps() ->withPivot('usado');;
    }

    public function userEstudiante()
    {
        return $this->belongsTo(User::class, 'user_estudiante_id');
    }

    public function userAdministrativo()
    {
        return $this->belongsTo(User::class, 'user_administrativo_id');
    }

    // public function servicioComprobantes()
    // {
    //     return $this->hasMany(ServicioComprobante::class);
    // }
}
