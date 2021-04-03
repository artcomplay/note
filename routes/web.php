<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function(){
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/index', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.index');
    Route::post('/create_section', [App\Http\Controllers\Admin\DashboardController::class, 'create_section'])->name('admin.create_section');
    Route::post('/remove_section', [App\Http\Controllers\Admin\DashboardController::class, 'remove_section'])->name('admin.remove_section');
    Route::post('/create_category', [App\Http\Controllers\Admin\DashboardController::class, 'create_category'])->name('admin.create_category');
    Route::post('/remove_category', [App\Http\Controllers\Admin\DashboardController::class, 'remove_category'])->name('admin.remove_category');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
