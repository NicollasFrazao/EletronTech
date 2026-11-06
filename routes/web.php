<?php

declare(strict_types=1);

use App\Http\Controllers\Tools\UnitConverterController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/tools/unit-converter', [UnitConverterController::class, 'show'])->name('tools.unit-converter');
Route::post('/tools/unit-converter', [UnitConverterController::class, 'convert'])->name('tools.unit-converter.convert');
