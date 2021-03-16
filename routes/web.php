<?php

use App\Http\Controllers\HolidayController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'holidays.check')->name('start');

Route::post('/', [HolidayController::class, 'check'])->name('holidays.check');
