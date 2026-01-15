<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'fecha_registro'
    ];

    public $timestamps = false;

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'cliente_id');
    }

    public function viajes()
    {
        return $this->belongsToMany(
            Viaje::class, 
            'cliente_viaje', 
            'cliente_id', 
            'viaje_id'
            )->withPivot('estatus', 'fecha_union');
    }
}
