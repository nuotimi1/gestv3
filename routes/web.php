<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
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

    Route::get('/customer/{customer}/dashboard',[CustomerController::class,'index'])->middleware(['identify:customer'])->name('customer.dashboard');


});
