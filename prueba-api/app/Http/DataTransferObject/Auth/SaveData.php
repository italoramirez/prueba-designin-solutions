<?php

namespace App\Http\DataTransferObject\Auth;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class SaveData extends Data
{
    public function __construct(
        public string $name,
        public ?string $email,
        public ?string $password,
        public string $age,
        public string $address
    ) {
    }

    public static function rules($userId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'age' => 'required|integer',
            'address' => 'required|string|max:255'
        ];
    }
}
