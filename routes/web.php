<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->middleware('admin');

// Route::get('/operation-enter', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->as('admin.')->middleware(['web', 'auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\OperationEnterController::class, 'dashboard'])->name('dashboard');

    Route::get('/operation-enter', [App\Http\Controllers\OperationEnterController::class, 'operationEnter'])->name('operation-enter');
    
    Route::get('/operation-history', [App\Http\Controllers\OperationEnterController::class, 'operationHistory'])->name('operation-history');
    Route::post('/operation-enter-save', [App\Http\Controllers\OperationEnterController::class, 'operationEnterSave'])->name('operation-enter-save');

    Route::get('/monthly-summary', [App\Http\Controllers\OperationEnterController::class, 'monthlySummary'])->name('monthly-summary');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile-update-password', [ProfileController::class, 'profileUpdatePassword'])->name('profile.update-password');
    Route::post('/profile-update-contact', [ProfileController::class, 'profileUpdateContact'])->name('profile.update-contact');
});

// Catch-all route for unauthorized access
Route::fallback(function () {
    return redirect()->route('login');
});

require __DIR__ . '/auth.php';
