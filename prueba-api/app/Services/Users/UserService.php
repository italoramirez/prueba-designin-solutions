<?php

namespace App\Services\Users;

use App\Http\DataTransferObject\User\UserData;
use App\Models\User;

interface UserService
{
    /**
     * @param UserData $userData
     * @return User
     */
    public function storage(UserData $userData): User;

    /**
     * @param UserData $userData
     * @param $id
     * @return User
     */
    public function update(UserData $userData, $id): User;

    /**
     * @param $id
     * @return void
     */
    public function delete($id): void;

    /**
     * @param int $id
     * @return User
     */
    public function show(int $id): User;

}
