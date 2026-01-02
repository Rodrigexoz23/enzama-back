<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'cliente_viaje';

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'viaje_id',
        'estatus',
        'fecha_union'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }
}
