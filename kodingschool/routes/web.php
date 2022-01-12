<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Matter\Show;
use Illuminate\Support\Facades\Route;
use App\Models\Language;
use App\Models\Matter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return view('welcome');
    }
})->name('home');

Route::name('verification.')->group(function() {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/dashboard');
    })->middleware(['auth', 'signed'])->name('verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('send');
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
