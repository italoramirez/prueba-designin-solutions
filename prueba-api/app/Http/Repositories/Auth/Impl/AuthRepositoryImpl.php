<?php

namespace App\Http\Repositories\Auth\Impl;

use App\Http\DataTransferObject\Auth\SaveData;
use App\Http\Repositories\Auth\AuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepositoryImpl implements AuthRepository
{
    /**
     * @param SaveData $data
     * @return User
     */
    public function create(SaveData $data): User
    {
        $data = [
            'name' => $data->name,
            'email' => $data->email,
            'age' => $data->age,
            'address' => $data->address,
            'password' => Hash::make($data->password)
        ];
        return User::create($data);
    }

    public function findByEmail(string $email): User
    {
        return User::whereEmail($email)->first();
    }
}
