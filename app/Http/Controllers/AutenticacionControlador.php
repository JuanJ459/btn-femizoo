<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\register;
use App\Http\Requests\login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AutenticacionControlador extends Controller
{
    public function register(register $res){
        if($res->accept_term){
            $user = new User();

        $user->name = $res->name;
        $user->celular = $res->celular;
        $user->email = $res->email;
        $user->password = bcrypt($res->password);
        $user->rol = 2;
        $user->accept_term = true; 
        

        $user->save();
        return response()->json([
            'res'=> true,
            'msg'=> 'Registro completado.'
        ],200);}else{
            return response()->json([
                'res'=> false,
                'msg'=> 'No aceptó los terminos y condiciones.'
            ],200);
        }
    }

    public function login(login $acces){
        $user = User::where('email', $acces->email)->first();
 
            if (! $user || ! Hash::check($acces->password, $user->password)) {
                throw ValidationException::withMessages([
                    'res' => false,
                    'msg' => ['El email o la contraseña son incorrectas'],
                ]);
            }
 
        $token = $user->createToken($acces->email)->plainTextToken;

        return response()->json([
            'res' => true,
            'token' => $token
        ],200);
    }

    public function logout(Request $res){
        $res->user()->currentAccessToken()->delete();
        return response()->json([
            'res' => true,
            'msg' => 'El token ha sido eliminado'
        ],200);
    }

    public function validateToken(Request $request){
        return response()->json([
            'res' => true,
            'msg' => 'Usuario autenticado.'
        ]);
    }
}
