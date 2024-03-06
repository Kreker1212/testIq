<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;


Route::get('links', [LinkController::class, 'index'])->name('links.index');
Route::post('links', [LinkController::class, 'store'])->name('links.store');
Route::get('links/{code}', [LinkController::class, 'show'])->name('links.show');
