<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViajeController extends Controller
{
    public function listarViajes(Request $request){
        $perPage = $request->get('per_page', 10);

        $viajes = DB::table('viajes')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($viajes);
    }
    
    public function guardarViaje(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'precio' => 'required|numeric',
        ]);

        DB::table('viajes')->insert([
            'Nombre' => $request->nombre,
            'Destino' => $request->destino,
            'Fecha_inicio' => $request->fecha_inicio,
            'Fecha_fin' => $request->fecha_fin,
            'Precio' => $request->precio,
            'Estado' => $request->estado,
            'Fecha_registro' => now(),
        ]);

        return response()->json(['mensaje' => 'Viaje agregado correctamente']);
    }
    public function eliminarViaje($id){
        DB::table('viajes')->where('id', $id)->delete();
        return response()->json(['mensaje' => 'Viaje eliminado correctamente']);
    }

    public function all(){
        return response()->json([
            'data' => DB::table('viajes')->select('id', 'nombre')->get()
        ]);
    }

}
