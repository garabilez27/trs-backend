<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        try {
            $user = User::create([
                'usr_name' => $validated['name'],
                'usr_email' => $validated['email'],
                'usr_password' => Hash::make($validated['password'])
            ]);

            return response()->json([
                'message' => 'User registered successfully.',
                'user' => $user
            ], 201);

        } catch (QueryException $e) {
            // Check for duplicate entry error (MySQL error code 1062)
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'error' => 'Email already exists.'
                ], 409);
            }

            // Other database errors
            return response()->json([
                'error' => 'Database error: ' . $e->getMessage()
            ], 500);

        } catch (\Exception $e) {
            // Catch any other errors
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $credentials = [
            'usr_email' => $validated['email'],
            'password' => $validated['password']
        ];

        try {
            $token = JWTAuth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'error' => 'Invalid credentials.'
                ], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'error' => 'Could not create token.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Return only necessary user info to prevent exposing sensitive data
            return response()->json([
                'id' => $user->usr_id,
                'name' => $user->usr_name,
                'email' => $user->usr_email
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token invalid'], 401);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token not provided'], 401);

        } catch (\Exception $e) {
            // Catch any other unexpected exceptions to prevent HTTP 500
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
