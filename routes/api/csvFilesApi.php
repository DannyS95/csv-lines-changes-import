<?php

use App\Http\Controllers\CSVLinesChangesController;
use Illuminate\Support\Facades\Route;


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

Route::post('/linesChanges', CSVLinesChangesController::class)->name('csvLines.changes');
