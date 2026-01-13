<?php

namespace App\Providers;

use App\Services\UserProvider\CacheUsersProvider;
use App\Services\UserProvider\Contracts\UsersProviderInterface;
use App\Services\UserProvider\JsonPlaceholderUsersProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UsersProviderInterface::class, function ($app) {
            $inner = new JsonPlaceholderUsersProvider(
                http: $app->make(HttpFactory::class),
                connectTimeout: (int) config('users.http.connect_timeout', 3),
                timeout: (int) config('users.http.timeout', 5),
                retryAttempts: (int) config('users.http.retry_attempts', 3),
                retrySleepMs: (int) config('users.http.retry_sleep_ms', 200),
            );

            return new CacheUsersProvider(
                inner: $inner,
                cache: $app->make(CacheRepository::class),
                cacheKey: (string) config('users.cache.key', 'users.provider.cache'),
                ttlSeconds: (int) config('users.cache.ttl', 300),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
