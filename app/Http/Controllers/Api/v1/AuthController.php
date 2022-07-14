<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Validator;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function login(Request $request)
    {
      
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 1,
                'message' => 'Validación incorrecta',
                'errors' => $validator->errors()
            ], 422);
        }

        $token = JWTAuth::attempt($credentials);

        if ($token) {
           
            $tokena = JWTAuth::parseToken();

            return response()->json([
                'success' => true,
                'user' => auth()->user(),
                'token' => $token,
                
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Credenciales incorrectas',
                'errors' => $validator->errors()
            ], 401);
        }

    }

    public function logout()
    {

        $token = JWTAuth::getToken();

        try {
            $token = JWTAuth::invalidate($token);
            return response()->json([
                'success' => true,
                'message' => "Has terminado tu sesion satisfactoriamente."
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar la sesión, por favor inténtalo de nuevo.'
            ], 422);
        }
    }
}
