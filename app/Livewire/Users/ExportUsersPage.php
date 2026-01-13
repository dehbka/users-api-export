<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Services\Export\ExportUsersToCsvService;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Psr\Log\LoggerInterface;
use Throwable;

class ExportUsersPage extends Component
{
    private ExportUsersToCsvService $exportService;
    private LoggerInterface $logger;

    public function boot(ExportUsersToCsvService $exportService, LoggerInterface $logger): void
    {
        $this->exportService = $exportService;
        $this->logger = $logger;
    }

    public function render()
    {
        return view('livewire.users.export-users-page');
    }

    public function download(): StreamedResponse|RedirectResponse
    {
        try {
            return $this->exportService->stream();
        } catch (Throwable $e) {
            $this->logger->error('Users export failed', [
                'exception' => $e,
                'message' => $e->getMessage(),
            ]);

            session()->flash('error', 'Failed to export users. Please try again later.');

            return redirect()->back();
        }
    }
}
