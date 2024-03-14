<?php

namespace App\Services\Auth\Impl;

use App\Http\DataTransferObject\Auth\LoginData;
use App\Http\DataTransferObject\Auth\SaveData;
use App\Http\Repositories\Auth\AuthRepository;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService
{

    public function __construct(
        protected AuthRepository $userRepository
    )
    {
    }

    /**
     * @param SaveData $data
     * @return array
     */
    public function register(SaveData $data): array
    {
        $user = $this->userRepository->create($data);
        $token = $user->createToken('authToken')->accessToken;
        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * @param LoginData $data
     * @return mixed
     * @throws \Exception
     */
    public function login(LoginData $data): mixed
    {
        $credentials = [
            'email' => $data->email,
            'password' => $data->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('authToken')->accessToken;
            return [
                'user' => auth()->user(),
                'token' => $token
            ];
        }

        $user = $this->userRepository->findByEmail($data->email);
        if (!isset($user)) {
            throw new \Exception('User not found');
        }

        if (Hash::check($data->password, $user->password)) {
            $tokenCreated = $user->createToken('authToken');
            return [
              'user' => $user,
              'token' => $tokenCreated->accessToken,
            ];
        }
        throw new \Exception('Invalid credentials');
    }
}
