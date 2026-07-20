<?php

use App\Features\Memos\Controllers\MemoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('memos', MemoController::class);
});
