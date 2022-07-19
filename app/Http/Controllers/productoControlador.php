<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\producto;

class productoControlador extends Controller
{
    public function index()
    {
        return producto::all();
    }

    public function store(Request $request)
    {
        if ($request->user()->rol == 'admin') {
            $pro = new producto();

            $pro->nombre = $request->nombre;
            $pro->imagen = $request->imagen;

            $pro->save();
            return response()->json([
                'res' => true,
                'msg' => 'Añadido correctamente'
            ], 200);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id, Request $request)
    {
        if ($request->user()->rol == 'admin') {
            $pro = producto::where('id', $id)->first();
            $pro->delete()->save();
        }
    }
}
