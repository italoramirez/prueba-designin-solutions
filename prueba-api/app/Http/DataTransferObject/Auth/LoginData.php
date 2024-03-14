<?php

namespace App\Http\DataTransferObject\Auth;

use Spatie\LaravelData\Data;

class LoginData extends Data
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public string $email,
        public string $password
    ) {}

    /**
     * @return string[]
     */
    public static function rules(): array
    {
        return [
            'email' => 'required|max:255',
            'password' => 'required|max:255'
        ];
    }

}
