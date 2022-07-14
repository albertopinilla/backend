<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Auth
{
   
    public function handle(Request $request, Closure $next)
    {
        if(!$user = auth()->user())
        {
            return response()->json([
                'success' => false,
                'message'=>'No autenticado'
            ], 404);
        }
      
        if(!$request->user()->can($request->route()->action['as'])){
            return response()->json([
                'success' => false,
                'message'=>'No autorizado'
            ], 404);
        }

        return $next($request);
    }
}
