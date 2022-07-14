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
}
