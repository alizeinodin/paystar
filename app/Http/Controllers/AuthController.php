<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $cleanData = $request->validated();
        $user = User::where('email', $cleanData['email'])->latest('id')->first();

        if (is_null($user)) {

            $user = User::create([
                'name' => $cleanData['name'],
                'email' => $cleanData['email'],
                'password' => bcrypt($cleanData['password']),
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Barber',
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }


    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $cleanData = $request->validated();

        $user = User::where('email', $cleanData['email'])->latest('id')->first();

        if (Auth::attempt(['email' => $cleanData['email'], 'password' => $cleanData['password']])) {

            $response = [
                'user' => $user,
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer',
            ];

            return \response()->json($response, Response::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete(); // logout from all devices

        $response = [
            'message' => 'You have successfully logged out!',
        ];

        return response()->json($response, Response::HTTP_NO_CONTENT);
    }

    public function getUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return \auth()->user();
    }
}
