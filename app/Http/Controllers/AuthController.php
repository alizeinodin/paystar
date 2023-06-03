<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
}
