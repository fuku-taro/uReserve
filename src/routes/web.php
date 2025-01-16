<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivewireTestController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(LivewireTestController::class)
->prefix('livewire-test')->group(function(){
    Route::get('index', 'index')->name('livewire-test.index');
});
