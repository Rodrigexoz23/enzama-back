<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Viaje;
use App\Models\Cliente;


class ReservaController extends Controller
{   
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'viaje_id' => 'required|exists:viajes,id',
            'estatus' => 'required|string'
        ]);

        $reservaExiste = Reserva::where('cliente_id', $request->cliente_id)
            ->where('viaje_id', $request->viaje_id)
            ->exists();

        if ($reservaExiste) {
            return response()->json([
                'mensaje' => 'La Clienta ya esta asignada a este viaje'
            ], 409);
        }
        $reserva = Reserva::create([
            'cliente_id' => $request->cliente_id,
            'viaje_id' => $request->viaje_id,
            'estatus' => $request->estatus,
        ]);

        return response()->json([
            'mensaje' => 'Reserva creada exitosamente',
            'reserva' => $reserva
        ], 201);
    }

    public function clientasPorViaje($viajeId)
    {
        $viaje = Viaje::with('clientas')->findOrFail($viajeId);

        return response()->json([
            'viaje' => $viaje->nombre ?? 'Viaje',
            'clientas' => $viaje->clientas
        ]);
    }

    public function viajesPorClienta($clientaId)
    {
        $cliente = Cliente::with('viajes')->findOrFail($clientaId);

        return response()->json([
            'cliente' => $cliente->nombre ?? 'Cliente',
            'viajes' => $cliente->viajes
        ]);
    }
}
