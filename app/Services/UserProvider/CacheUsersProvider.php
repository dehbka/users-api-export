<?php

declare(strict_types=1);

namespace App\Services\UserProvider;

use App\Services\UserProvider\Contracts\UsersProviderInterface;
use App\Services\UserProvider\DTOs\UserDto;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

final readonly class CacheUsersProvider implements UsersProviderInterface
{
    public function __construct(
        private UsersProviderInterface $inner,
        private CacheRepository $cache,
        private string $cacheKey = 'users.provider.cache',
        private int $ttlSeconds = 300,
    ) {
    }

    /**
     * @return array<UserDto>
     */
    public function fetch(): array
    {
        $raw = $this->cache->remember($this->cacheKey, $this->ttlSeconds, function () {
            $items = $this->inner->fetch();

            return array_map(static fn (UserDto $user) => $user->toArray(), $items);
        });

        if (!is_array($raw)) {
            return $this->inner->fetch();
        }

        return array_map(static fn (array $item) => UserDto::from($item), $raw);
    }
}
