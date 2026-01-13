<?php

declare(strict_types=1);

namespace App\Services\UserProvider\DTOs;

use Spatie\LaravelData\Data;

class CompanyDto extends Data
{
    public function __construct(
        public string $name,
        public string $catchPhrase,
        public string $bs,
    ) {
    }
}
