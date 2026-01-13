<?php

declare(strict_types=1);

namespace App\Services\UserProvider\DTOs;

use Spatie\LaravelData\Data;

class UserDto extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $username,
        public string $email,
        public AddressDto $address,
        public string $phone,
        public string $website,
        public CompanyDto $company,
    ) {
    }
}
