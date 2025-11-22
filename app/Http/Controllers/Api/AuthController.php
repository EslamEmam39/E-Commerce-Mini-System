<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequset;
use App\Http\Requests\RegisterRequset;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(RegisterRequset $request)
    {

            $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            ]);

          try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return ApiResponse::error([], 'Failed to create token', 500);
        }

          return ApiResponse::success($user ,  $token , 'User created successfully', 201);
     } // end register


         public function login(LoginRequset $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ApiResponse::error([], 'email not found', 404);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::error([], 'Invalid credentials', 401);
            }
        } catch (JWTException $e) {
            return ApiResponse::error([], 'Failed to create token', 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token ,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    } /// end login


        public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
          return ApiResponse::error([], 'Failed to logout, please try again', 500);

        }

        return ApiResponse::success(null , null , 'User logged out successfully', 200);
    } // end logout


        public function getUser()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                ApiResponse::error([], 'User not found', 404);
            }
           return ApiResponse::success($user);

        } catch (JWTException $e) {
            return ApiResponse::error([], 'Failed to get user', 500);
        }
    } // end getUser

 public function updateUser(UpdateUserRequest  $request)
    {

  try {
        $user = Auth::user();
        if (!$user) {
            return ApiResponse::error([], 'User not found', 404);
        }

        $user->update($request->only(['name', 'email']));

        return ApiResponse::success($user);

    } catch (JWTException $e) {
        return ApiResponse::error([], 'Failed to update user profile', 500);
    }

    } // end updateUser

}
