<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Viaje;

class ViajeController extends Controller
{
    public function listarViajes(Request $request){
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $query = Viaje::orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                ->orWhere('destino', 'like', "%$search%");
            });
        }
        $viajes = $query->paginate($perPage);
        return response()->json($viajes);
    }
    
    public function guardarViaje(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'precio' => 'required|numeric|min:0',
        ]);

        $viaje = Viaje::create([
            'nombre' => $request->nombre,
            'destino' => $request->destino,
            'fecha_inicio' => $request->fecha_inicio,
            'precio' => $request->precio,
            'descuento' => $request->descuento ?? 0,
            'estado' => $request->estado ?? 'activo',
        ]);
        return response()->json(['mensaje' => 'Viaje agregado correctamente']);
    }

    public function eliminarViaje($id){
        $viaje = Viaje::findOrFail($id);
        $viaje->delete();
        return response()->json(['mensaje'=>'Viaje eliminado correctamente']);
    }

    public function all(){
        $viajes = Viaje::select('id', 'nombre')->get();
        return response()->json(['data' => $viajes]);
    }

}
