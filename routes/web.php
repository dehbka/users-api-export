<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Users\ExportUsersPage;

Route::get('/', ExportUsersPage::class)->name('users.page');
