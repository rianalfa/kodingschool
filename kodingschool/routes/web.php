<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Language\Grid;
use App\Http\Livewire\Language\Show as LanguageShow;
use App\Http\Livewire\Leaderboard;
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

Route::group(['prefix' => 'email', 'as' => 'verification.'], function() {
    Route::get('/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('notice');

    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/dashboard');
    })->middleware(['auth', 'signed'])->name('verify');

    Route::post('/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('send');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', Grid::class)->name('dashboard');

    Route::name('study.')->group(function() {
        Route::get('/language/{id}', LanguageShow::class)->name('language');

        Route::get('/matter/{id}', Show::class)->name('matter');
    });

    Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');
});
