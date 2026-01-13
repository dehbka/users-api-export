<?php

declare(strict_types=1);

namespace App\Services\UserProvider;

use App\Services\UserProvider\Contracts\UsersProviderInterface;
use App\Services\UserProvider\DTOs\UserDto;
use App\Services\UserProvider\Exceptions\InvalidJsonException;
use App\Services\UserProvider\Exceptions\UsersProviderException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory as HttpFactory;
use Spatie\LaravelData\Exceptions\CannotCreateData;

final readonly class JsonPlaceholderUsersProvider implements UsersProviderInterface
{
    private const string URL = 'https://jsonplaceholder.typicode.com/users';

    public function __construct(
        private HttpFactory $http,
        private int $connectTimeout = 3,
        private int $timeout = 5,
        private int $retryAttempts = 3,
        private int $retrySleepMs = 200,
    ) {
    }

    /**
     * @return array<UserDto>
     *
     * @throws UsersProviderException
     */
    public function fetch(): array
    {
        try {
            $response = $this->http->acceptJson()
                ->timeout($this->timeout)
                ->connectTimeout($this->connectTimeout)
                ->retry($this->retryAttempts, $this->retrySleepMs)
                ->get(self::URL);
        } catch (ConnectionException $e) {
            throw new UsersProviderException($e->getMessage());
        }


        if (!$response->successful()) {
            throw new UsersProviderException('Failed to fetch users: HTTP '.$response->status());
        }

        $payload = $response->json();

        if (!is_array($payload)) {
            throw new UsersProviderException('Invalid users payload');
        }

        try {
            return UserDto::collect($payload);
        } catch (CannotCreateData) {
            throw new InvalidJsonException();
        }
    }
}
