<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use DateTimeInterface;
use Spatie\Permission\Traits\HasRoles;
use Validator;

class User extends Authenticatable implements JWTSubject
{
    //use HasApiTokens, HasFactory, Notifiable;
    use HasFactory, Notifiable;
    use HasRoles;
    //protected $guard = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    static public function getUsers()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'users' => $users
        ], 200);
    }

    static public function saveUser($request)
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
}
