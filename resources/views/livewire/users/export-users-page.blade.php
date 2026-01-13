<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Експорт користувачів у CSV</h1>

    @if (session('error'))
        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @error('export')
        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800" role="alert">
            {{ $message }}
        </div>
    @enderror

    <button wire:click="download" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Завантажити CSV
    </button>

    <span wire:loading class="ml-3 text-gray-600">Генерація файлу...</span>
</div>
