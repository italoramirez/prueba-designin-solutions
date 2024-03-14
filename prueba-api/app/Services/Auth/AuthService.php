<?php

namespace App\Services\Auth;

use App\Http\DataTransferObject\Auth\LoginData;
use App\Http\DataTransferObject\Auth\SaveData;

interface AuthService
{
    /**
     * @param SaveData $data
     * @return mixed
     */
    public function register(SaveData$data): mixed;

    /**
     * @param LoginData $data
     * @return mixed
     */
    public function login(LoginData $data): mixed;
}
