<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function listarClientes(Request $request){
        $perPage = $request->get('per_page', 5);
        $search  = $request->get('search');

        $query = DB::table('clientes')->orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                ->orWhere('apellido', 'like', "%$search%")
                ->orWhere('telefono', 'like', "%$search%");
            });
        }
        $clientes = $query->paginate($perPage);
        return response()->json($clientes);
    }

    public function guardarCliente(Request $request){
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'required|string|max:10',
        ]);

        DB::table('clientes')->insert([
            'Nombre' => $request->nombre,
            'Apellido' => $request->apellido,
            'Telefono' => $request->telefono,
            'Fecha_registro' => now(),
        ]);

        return response()->json(['mensaje' => 'Clienta agregada correctamente']);
    }
    public function eliminarCliente($id){
        DB::table('clientes')->where('id', $id)->delete();
        return response()->json(['mensaje' => 'Clienta eliminada correctamente']);
    }
}