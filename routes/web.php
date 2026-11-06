<?php

declare(strict_types=1);

use App\Http\Controllers\Tools\CalculatorController;
use App\Http\Controllers\Tools\UnitConverterController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/tools/unit-converter', [UnitConverterController::class, 'show'])->name('tools.unit-converter');
Route::post('/tools/unit-converter', [UnitConverterController::class, 'convert'])->name('tools.unit-converter.convert');

Route::get('/tools/calculators', [CalculatorController::class, 'index'])->name('tools.calculators');
Route::post('/tools/calculators/{calculator}', [CalculatorController::class, 'calculate'])->name('tools.calculators.calculate');
