<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Database\QueryException;
use JWTAuth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function users()
    {

        $users = User::all();

        return response()->json([
            'success' => true,
            'users' => $users
        ], 200);
    }

    public function store(Request $request)
    {

        $user = $request->only('name', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($user, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt($user['password']),
            ]);

            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'El usuario ha sido creado satisfactoriamente.'
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                $e
            ], 500);
        }
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
        $data = $request->only('name', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
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
            return response()->json([
                'success' => true,
                'user' => $user,
                'message' => 'El usuario ha sido actualizado satisfactoriamente.'

            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Recurso no encontrado'
            ], 404);
        }
    }
}
