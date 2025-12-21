<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    protected $table = 'viajes';

    protected $fillable = [
        'nombre',
        'destino',
        'fecha_inicio',
        'fecha_fin',
        'precio',
        'estado'
    ];

    public $timestamps = false;

    // public function clientes()
    // {
    //     return $this->belongsToMany(
    //         Cliente::class,
    //         'cliente_viaje',
    //         'viaje_id',
    //         'cliente_id'
    //     )->withPivot('estatus', 'fecha_union');
    // }
}
