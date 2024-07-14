<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Register;
use App\Livewire\Login;
use App\Livewire\Dashboard;
use App\Livewire\Logout;
use App\Livewire\Karyawan;
use App\Livewire\AttendanceManager;
use App\Livewire\AttendanceReport;


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
    return redirect()->to('/login');
});

Route::group(['middleware'=>'guest'], function(){
    Route::get('/login', Login::class)->name('login');
});

// Route::group(['middleware'=>'auth'], function(){
//     Route::get('/dashboard', Dashboard::class)->name('dashboard');
//     Route::get('/logout', Logout::class)->name('logout');
//     Route::get('/register', Register::class)->name('register');
//     Route::get('/karyawan', Karyawan::class)->name('karyawan');
//     Route::get('/attendance', AttendanceManager::class)->name('attendance');
//     Route::get('/attendance-report', AttendanceReport::class)->name('attendance-report');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/logout', Logout::class)->name('logout');
    Route::get('/attendance', AttendanceManager::class)->name('attendance');
    // Route::get('/register', Register::class)->name('register');

    // Middleware untuk Manager (misalnya position_id != 1)
    Route::middleware(['check.position:2'])->group(function () {
        Route::get('/karyawan', Karyawan::class)->name('karyawan');
        Route::get('/attendance-report', AttendanceReport::class)->name('attendance-report');

    });

});