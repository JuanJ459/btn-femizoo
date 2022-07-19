<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\addproduct;
use App\Http\Requests\update;
use App\Models\dispositivos;

class dispositivosControlador extends Controller
{
    public function index(Request $request)
    {
        $disps = dispositivos::join('productos', 'dispositivos.producto_id', '=', 'productos.id')->select('*')->where('user_id', $request->user()->id)->get();
        $dispositivo = array();
        foreach($disps as $d):
            array_push($dispositivo, $d);
        endforeach;
        return $dispositivo;
    }
  
    public function actualizar(addproduct $request)
    {
        $ndis = dispositivos::where('serie', $request->serie)->first();
        if($ndis){
            if($ndis->user_id == null){
                $ndis->user_id = $request->user()->id;
                $ndis->propietario = $request->propietario;
                $ndis->desaparecido = false;
                $ndis->save();
                return response()->json([
                    'res' => true,
                    'msg' => 'El dispositivo se registró correctamente al usuario'
                ],200);
            }else{
                return response()->json([
                    'res' => false,
                    'msg' => 'El dispositivo ya tiene dueño'
                ],200);
            }
        }else{
            return response()->json([
                'res' => false,
                'msg' => 'El número de serie no existe'
            ],200);
        }
    }

    public function edit($id)
    {
       
    }

    public function update(update $request)
    {
        $dis = dispositivos::where('serie', $request->serie)->first();
        $dis->latitud = $request->latiutd;
        $dis->longitd = $request->longitud;
        $dis->save();

        return response()->json([
            'res' => true,
            'msg' => 'Ubicación actualizada correctamente'
        ],200);
    }

    public function destroy(Request $res)
    {
        $dis = dispositivos::where('serie', $res->serie)->first();
        if($res->user()->id = $dis->user_id){
            $dis->user_id = null;
            $dis->propietario = "none";
            $dis->save();
        }
        
        return response()->json([
            'res' => true,
            'msg' => 'Tu lista de articulos se actualizó correctamente'
        ],200);
    }

    public function perdido($serie){
        $dis = dispositivos::where('serie', $serie)->first();
        $dis->desaparecido = true;

        $dis->save();
        return response()->json([
            'res' => true,
            'msg' => 'Su dispositivo se ha reportado como desaparecido.'
        ],200);
    }
}
