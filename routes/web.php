<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('employee')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('employee');

    Route::get('/update/{id}', [UserController::class, 'getUserById'])->name('employee.update.show')->middleware('user.valid');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('employee.update.store');

    // Route::get('/sort/{column}/{direction}', [UserController::class, 'sort'])->name('sort');
    Route::get('/sort', [UserController::class, 'sort'])->name('sort')->middleware('sort.valid');
});
// Route::resource('/user', UserController::class);

// Route::middleware('auth')->resource('/timesheet', TimesheetController::class);

Route::middleware('auth')->prefix('/timesheet')->group(function() {
    Route::get('/create', [TimesheetController::class, 'create']);
    Route::post('/create', [TimesheetController::class, 'store'])->name('store');
});


require __DIR__.'/auth.php';
