<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFilesDifferenceController;


/*
|--------------------------------------------------------------------------
| API Routes - Data Files
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/difference', DataFilesDifferenceController::class)->name('dataFiles.difference');