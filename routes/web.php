<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\GrantPermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'verified')->prefix('employee')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('employee');
    Route::post('/', [UserController::class, 'index'])->name('employee.search');

    Route::get('/profile/{id}', [UserController::class, 'profile'])->name('employee.profile')->middleware('user.valid');

    Route::get('/create', [UserController::class, 'create'])->name('employee.create.show');
    Route::post('/create', [UserController::class, 'store'])->name('employee.create.store');

    Route::get('/update/{id}', [UserController::class, 'getUserById'])->name('employee.update.show')->middleware('user.valid');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('employee.update.store');

    // Route::get('/sort/{column}/{direction}', [UserController::class, 'sort'])->name('sort');
    // Route::get('/sort', [UserController::class, 'sort'])->name('sort')->middleware('sort.valid');
    // Route::post('/sort', [UserController::class, 'sort'])->name('sort')->middleware('sort.valid');
});
// Route::resource('/user', UserController::class);

// Route::middleware('auth', 'verified', 'timesheet.valid')->resource('/timesheet', TimesheetController::class);
// Route::post('/timesheet/{id}', [TimesheetController::class, 'update'])->middleware('auth', 'verified', 'timesheet.valid')->name('timesheet.save');

Route::middleware('auth', 'verified', 'timesheet.valid')->prefix('/timesheet')->name('timesheet.')->group(function() {
    Route::match(['get', 'post'], '/', [TimesheetController::class, 'index'])->name('index');

    Route::get('/create', [TimesheetController::class, 'create'])->name('create');
    Route::post('/create', [TimesheetController::class, 'store'])->name('store');

    Route::get('/{id}', [TimesheetController::class, 'edit'])->name('edit');
    Route::post('/{id}', [TimesheetController::class, 'update'])->name('save');

    Route::get('/delete/{id}', [TimesheetController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth', 'admin.check')->name('permission.')->prefix('permission')->group(function() {
    Route::get('/', [GrantPermissionController::class, 'index'])->name('index');
    Route::post('/', [GrantPermissionController::class, 'index'])->name('search');

    Route::get('/grant/{id}', [GrantPermissionController::class, 'show'])->name('grant.show')->middleware('user.valid');
    Route::post('/grant/{id}', [GrantPermissionController::class, 'grant'])->name('grant.create');
});

require __DIR__.'/auth.php';
