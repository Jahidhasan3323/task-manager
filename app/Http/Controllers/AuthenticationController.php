<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends BaseController
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken(config('sanctum.token_salt'))->plainTextToken;
            $success['user'] =  $user;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else {
            return $this->sendError('Unauthorised.', ['error'=>'Credential not match']);
        }
    }
}
