<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'precio',
    ];

    public function comprobantes()
    {
        return $this->belongsToMany(Comprobante::class, 'servicio_comprobantes', 'servicio_id', 'comprobante_id')->withTimestamps();
    }
}
