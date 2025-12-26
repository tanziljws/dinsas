<?php

use App\Livewire\GuruDashboard;
use App\Livewire\GuruLogin;
use App\Livewire\SubmissionForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect home to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login Route (Guest only)
Route::get('/login', GuruLogin::class)
    ->middleware('guest')
    ->name('login');

// Protected Guru Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', GuruDashboard::class)->name('guru.dashboard');
    Route::get('/submit/{id?}', SubmissionForm::class)->name('form.submit');
    Route::get('/settings', \App\Livewire\GuruSettings::class)->name('guru.settings');

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');
});

// Success page (accessible after redirect)
Route::get('/success', function () {
    return view('success');
})->name('form.success');
