<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Helpers\ResponseHelper;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){
        $data = $request->validated();
        $data = RequestHelper::sanitize($data);
        $data['password'] = Hash::make($data['password']); 
        $user = User::Create($data);
        // Dispatch the welcome email job
        SendWelcomeEmail::dispatch($user);
        return ResponseHelper::create(201,["user" => $user]);
    }

    public function login(LoginRequest $request){
        if(!Auth::attempt($request->only("email","password"))) {
            return ResponseHelper::create(401, null, "Please check your credentials");
        }
        $user = $request->user();
        $token = $user->createToken('api_token')->plainTextToken;
        return ResponseHelper::create(200,["user" => $user, "token" => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ResponseHelper::create(200, null, "Logout success");
    }

}
