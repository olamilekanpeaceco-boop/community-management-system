<?php

use App\Features\Meetings\Models\Meeting;
use App\Features\Meetings\Controllers\MeetingController;
use App\Features\Meetings\Controllers\MeetingMinuteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('meetings', MeetingController::class);
    Route::resource('meetings.minutes', MeetingMinuteController::class)->shallow();
    Route::get('meetings/{meeting}/minutes-search', [MeetingMinuteController::class, 'search'])->name('meetings.minutes.search');
    Route::get('meetings/{meeting}/minutes/{minute}/download', [MeetingMinuteController::class, 'downloadPdf'])->name('meetings.minutes.downloadPdf');
});
