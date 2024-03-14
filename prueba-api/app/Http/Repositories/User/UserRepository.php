<?php

namespace App\Http\Repositories\User;

use App\Http\DataTransferObject\User\UserData;
use App\Models\User;

interface UserRepository
{
    /**
     * @param array $userData
     * @return User
     */
    public function storage(array $userData): User;

    /**
     * @param array $userData
     * @param int $user
     * @return User
     */
    public function update(array $userData, int $user): User;

    /**
     * @param $id
     * @return User
     */
    public function getById($id): User;

    /**
     * @param User $user
     * @return void
     */
    public function delete(User $user): void;

    public function show(int $id): User;
}
