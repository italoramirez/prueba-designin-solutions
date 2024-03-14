<?php

namespace App\Http\Repositories\Auth;

use App\Http\DataTransferObject\Auth\LoginData;
use App\Http\DataTransferObject\Auth\SaveData;
use App\Models\User;

interface AuthRepository
{
    /**
     * @param SaveData $data
     * @return User
     */
    public function create(SaveData $data): User;

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User;

}
