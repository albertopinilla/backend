<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function users()
    {
        return User::getUsers();
       
    }

    public function store(Request $request)
    {
        return User::saveUser($request);
    }

    public function show($id)
    {
        try {

            $user = User::FindOrFail($id);
            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }

    public function delete($id)
    {

        try {

            $user = User::FindOrFail($id);
            $user->delete();
            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'El usuario ha sido eliminado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->only('name', 'email', 'password', 'password_confirmation','role_id');

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',
            //'role_id' => 'integer|digits:1|not_in:0|nullable'
            'role_id' => 'required|array'
        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $user = User::FindOrFail($id);

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $user->syncRoles($data['role_id']);

            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'El usuario ha sido actualizado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error con la actualización del usuario.'
            ], 404);
        }
    }
}
