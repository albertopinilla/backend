<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function roles()
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'users' => $roles
        ], 200);
    }

    public function store(Request $request)
    {
        return Role::saveRole($request);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->syncPermissions($request->all());
    }

    public function delete($id)
    {
       
        
        try {

            $role = Role::findOrFail($id); 
            
            $role->delete();
            return response()->json([
                'success' => true,
                'role' => $role,
                'message' => 'El rol ha sido eliminado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }

}
