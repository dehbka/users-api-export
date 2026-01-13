<?php

declare(strict_types=1);

namespace App\Services\UserProvider\Contracts;

use App\Services\UserProvider\DTOs\UserDto;
use App\Services\UserProvider\Exceptions\UsersProviderException;

interface UsersProviderInterface
{
    /**
     * Fetch users from a remote source and map them to Data DTOs.
     *
     * @return array<UserDto>
     *
     * @throws UsersProviderException
     */
    public function fetch(): array;
}
