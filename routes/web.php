<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', HomeController::class)->name('home');

Route::middleware('api')
    ->prefix('api/csvFiles')
    ->group(base_path('routes/api/csvFilesApi.php'));
