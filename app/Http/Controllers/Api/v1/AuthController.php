<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        

     
        if (JWTAuth::attempt($credentials)) {

            $token = auth('api')->claims([
                'role' => auth()->user()->getRoleNames(),
                'username' => auth()->user()->name
            ])->login(auth()->user());

            return response()->json([
                'success' => true,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'expires_in' => auth()->factory()->getTTL(),
                'end' => Carbon::now()->addMinutes(auth()->factory()->getTTL())->format('Y-m-d H:i:s'),
                'roles' => Auth::user()->getRoleNames(),
                'token' => $token,

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Credenciales incorrectas',
                'errors' => $validator->errors()
            ], 4011);
        }
    }

    public function logout()
    {
        
        try {
            auth()->logout();
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

    public function me()
    {
        if(auth()->user())
        {
            return response()->json(['auth' => true]);
        }else{
            return response()->json(['auth' => false]);
        }
        
    }
}
