<?php

use App\Features\Meetings\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('meetings', MeetingController::class);
});
