<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Matter\Show;
use Illuminate\Support\Facades\Route;
use App\Models\Language;
use App\Models\Matter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/language/{language}', function(Language $language) {
        return view('language.show', ['language' => $language]);
    })->name('language.show');

    Route::get('/matter/{matter}', function(Matter $matter) {
        return view('matter', ['matter' => $matter]);
    })->name('matter.show');
});
