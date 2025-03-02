<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if(Auth::attempt($request->only("email", "password"))) {
            $request->session()->regenerate();


            return response()->json([
                "success" => true,
                "code" => Response::HTTP_OK,
                "message" => "logged in successfully",
            ], Response::HTTP_OK);
        }

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'email atau password anda salah',
            'code' => Response::HTTP_UNAUTHORIZED
        ], Response::HTTP_UNAUTHORIZED));
    }
}
