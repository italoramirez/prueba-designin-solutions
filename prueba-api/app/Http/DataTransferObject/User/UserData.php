<?php

namespace App\Http\DataTransferObject\User;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    /**
     * @param string|null $name
     * @param int|null $age
     * @param string|null $address
     */
    public function __construct(
        public ?string $name,
        public ?int $age,
        public ?string $address
    )
    {
    }

    /**
     * @return string[]
     */
    public static function rules(): array
    {
        return [
            'name' => 'nullable|max:255',
            'age' => 'nullable|integer',
            'address' => 'nullable|max:255'
        ];
    }
}
