<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('reports/meetings', [ReportController::class, 'meetings'])->name('reports.meetings');
    Route::get('reports/committees', [ReportController::class, 'committees'])->name('reports.committees');
    Route::get('reports/members', [ReportController::class, 'members'])->name('reports.members');

    // Exports
    Route::get('reports/{type}/export', [ReportController::class, 'export'])->name('reports.export');
});
