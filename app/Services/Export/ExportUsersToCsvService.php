<?php

declare(strict_types=1);

namespace App\Services\Export;

use App\Services\UserProvider\Contracts\UsersProviderInterface;
use League\Csv\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class ExportUsersToCsvService
{
    public function __construct(
        private UsersProviderInterface $usersProvider,
        private UserCsvRowMapper $rowMapper,
        private string $delimiter = ',',
        private string $enclosure = '"',
        private string $escape = '\\',
    ) {
    }

    public function stream(): StreamedResponse
    {
        $users = $this->usersProvider->fetch();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ];

        return response()->streamDownload(function () use ($users): void {
            $stream = fopen('php://output', 'wb');

            if ($stream === false) {
                return;
            }

            $writer = Writer::from($stream);
            $writer->setDelimiter($this->delimiter);
            $writer->setEnclosure($this->enclosure);
            $writer->setEscape($this->escape);
            $writer->setOutputBOM(Writer::BOM_UTF8);

            $writer->insertOne($this->rowMapper->header());

            foreach ($users as $user) {
                $writer->insertOne($this->rowMapper->map($user));
            }
        }, 'users-export.csv', $headers);
    }
}
