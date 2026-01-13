<?php

declare(strict_types=1);

namespace App\Services\Export;

use App\Services\UserProvider\DTOs\UserDto;

final class UserCsvRowMapper
{
    public function header(): array
    {
        return ['id', 'name', 'username', 'email', 'address', 'phone', 'website', 'company'];
    }

    /**
     * @return array{0:int|float|string|null}
     */
    public function map(UserDto $user): array
    {
        $address = $this->formatItems(
            $user->address->street,
            $user->address->suite,
            $user->address->city,
            $user->address->zipcode,
        );

        $company = $this->formatItems(
            $user->company->name,
            $user->company->catchPhrase,
            $user->company->bs,
        );

        return [
            $user->id,
            $this->sanitizeCsvField($user->name),
            $this->sanitizeCsvField($user->username),
            $this->sanitizeCsvField($user->email),
            $this->sanitizeCsvField($address),
            $this->sanitizeCsvField($user->phone),
            $this->sanitizeCsvField($user->website),
            $this->sanitizeCsvField($company),
        ];
    }

    /**
     * Join given items with a comma and space, skipping empty strings.
     */
    private function formatItems(string ...$items): string
    {
        return implode(', ', array_filter($items, static fn ($v) => $v !== ''));
    }

    private function sanitizeCsvField(string $value): string
    {
        $trimmed = ltrim($value);
        if ($trimmed !== '' && in_array($trimmed[0], ['=', '+', '-', '@'], true)) {
            return "'".$value;
        }

        return $value;
    }
}
