<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Validator;

class RoleController extends Controller
{
    private $message = 'Recurso no encontrado';

    public function roles()
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'roles' => $roles
        ], 200);
    }

    public function show($id)
    {
        try {

            $user = Role::FindOrFail($id);
            return response()->json([
                'success' => true,
                'role' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->message
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $data = $request->only('name');

        $validator = Validator::make($data, [
            'name'  => 'required|unique:roles',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        try {

            Role::create([
                'name' => $request->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'El rol ha sido creado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->message
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {

        try {

            $role = Role::findOrFail($id);
            $role->syncPermissions($request->all());
            return response()->json([
                'success' => true,
                'role' => $role,
                'message' => 'El rol ha sido actualizado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $this->message
            ], 404);
        }
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
                'message' => $this->message
            ], 404);
        }
    }
}
