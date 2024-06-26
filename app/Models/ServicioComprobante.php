<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioComprobante extends Model
{
    use HasFactory;

    protected $table = 'servicio_comprobantes';

    protected $fillable = [
        'comprobante_id',
        'servicio_id',
        // 'precio_s',
        'usado'
    ];

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }


}
