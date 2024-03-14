<?php

namespace App\Http\Repositories\User\Impl;

use App\Http\DataTransferObject\User\UserData;
use App\Http\Repositories\User\UserRepository;
use App\Models\User;

class UserRepositoryImpl implements UserRepository
{

    /**
     * @param array $userData
     * @return User
     */
    public function storage(array $userData): User
    {
        return User::create($userData);
    }

    /**
     * @param array $userData
     * @param User $user
     * @return User
     */
    public function update(array $userData, $user): User
    {
        $user->update($userData);
        return $user;
    }

    /**
     * @param $id
     * @return User
     */
    public function getById($id): User
    {
        return User::find($id);
    }

    /**
     * @param User $user
     * @return void
     */
    public function delete(User $user): void
    {
        $user->delete();
    }

    public function show(int $id): User
    {
        return User::findorFail($id);
    }
}
