<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function user(){

        try {

            $user = User::all();
            $regusterUser =  UserResource::collection($user);
            
            return response()->json([
                'status' => true,
                'message' => 'User list',
                'data' => $regusterUser,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve user list',
                'error' => $e->getMessage(),
            ], 500);
        }

        
    }

    public function register(Request $request): JsonResponse
    {

        try{

            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|max:255',
                'email'     => 'required|string|email|max:255|unique:users',
                'password'  => 'required|string|min:8'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

          // $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => new UserResource($user),
                // 'access_token'  => $token,
                // 'token_type'    => 'Bearer'
            ], 201);

        } catch (\Throwable $th){

            return response()->json(['status' => false,'message' => $th->getMessage()], 500);

        }

    }

    public function login(Request $request): JsonResponse
    {

        try{

            $validator = Validator::make($request->all(), [
                'email'     => 'required|string|email|max:255',
                'password'  => 'required|string|min:8'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'data' => new UserResource($user),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Throwable $th){

            return response()->json(['status' => false,'message' => $th->getMessage()], 500);

        }

    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }


}
