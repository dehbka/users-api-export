<?php

declare(strict_types=1);

namespace App\Services\UserProvider\DTOs;

use Spatie\LaravelData\Data;

class AddressDto extends Data
{
    public function __construct(
        public string $street,
        public string $suite,
        public string $city,
        public string $zipcode,
    ) {
    }
}
