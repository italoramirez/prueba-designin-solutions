<?php

namespace App\Services\Users\Impl;

use App\Http\DataTransferObject\User\UserData;
use App\Http\Repositories\User\UserRepository;
use App\Models\User;
use App\Services\Users\UserService;

class UserServiceImpl implements  UserService
{
      public  function __construct(
          protected UserRepository $userRepository
      )
      {
      }

    /**
     * @param UserData $userData
     * @return User
     */
    public function storage(UserData $userData): User
    {
        $payload = [
            'email' => $userData->email,
            'name' => $userData->name,
            'age' => $userData->age,
            'address' => $userData->address
        ];
        return $this->userRepository->storage($payload);
    }

    public function update(UserData $userData, $id): User
    {
        $user = $this->userRepository->getById($id);
        $payload = [
            'name' => $userData->name,
            'age' => $userData->age,
            'address' => $userData->address
        ];
        return $this->userRepository->update($payload, $user);
    }

    public function delete($id): void
    {
        $user = $this->userRepository->getById($id);
        $this->userRepository->delete($user);
    }

    /**
     * @param int $id
     * @return User
     */
    public function show(int $id): User
    {
        return $this->userRepository->show($id);
    }
}
