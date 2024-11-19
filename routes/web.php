<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResenasController;

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
    return view('home');
})->name('home');

Route::get('/proposito', function () {
    return view('proposito');
})->name('proposito');
Route::get('reseñas', [ResenasController::class, 'index'])->name('reseñas');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/add', [UserController::class, 'create'])->name('users.add');
    Route::post('users/add', [UserController::class, 'store'])->name('users.register');
    Route::get('users/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users', [UserController::class, 'update'])->name('users.update');

    Route::get('forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('forms/add', [FormController::class, 'create'])->name('forms.add');
    Route::post('forms/add', [FormController::class, 'store'])->name('forms.register');
    Route::delete('forms', [FormController::class, 'destroy'])->name('forms.delete');
    Route::get('forms/{id}', [FormController::class, 'previsualizer'])->name('forms.previsualizer');
});

require __DIR__ . '/auth.php';
