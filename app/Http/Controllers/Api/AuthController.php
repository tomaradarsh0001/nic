<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use DB;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
       
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status == '1') {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user->tokens()->delete();
                $token = $user->createToken('api_token')->plainTextToken;
                // Fetch roles associated with the user
                $roles = DB::table('model_has_roles')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('model_has_roles.model_id', $user->id)
                ->pluck('roles.name'); // Assume 'name' is the column for role names

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user' => $user,
                    'roles' => $roles,
                ], 200);
            }

            return response()->json([
                'message' => 'Login Unsuccessfull',
                'User' => 'Invalid Credentials'
            ], 401);
        }

        return response()->json([
            'message' => 'User is not active or does not exist',
        ], 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout Succesfull',
                'status' => 'Success'
            ], 200);
        }

        return response()->json([
            'message' => 'Unable to logout',
        ], 400);
    }
}