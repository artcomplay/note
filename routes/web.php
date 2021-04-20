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

    Route::post('/create_note', [App\Http\Controllers\Admin\DashboardController::class, 'create_note'])->name('admin.create_note');
    Route::get('/element_data', [App\Http\Controllers\Admin\DashboardController::class, 'element_data'])->name('admin.element_data');
    Route::post('/remove_element', [App\Http\Controllers\Admin\DashboardController::class, 'remove_element'])->name('admin.remove_element');
    Route::get('/get_remove_elements', [App\Http\Controllers\Admin\DashboardController::class, 'get_remove_elements'])->name('admin.get_remove_elements');
    Route::post('/show_elements', [App\Http\Controllers\Admin\DashboardController::class, 'show_elements'])->name('admin.show_elements');
    Route::post('/edit_element', [App\Http\Controllers\Admin\DashboardController::class, 'edit_element'])->name('admin.edit_element');
    Route::post('/create_attr', [App\Http\Controllers\Admin\DashboardController::class, 'create_attr'])->name('admin.create_attr');
    Route::post('/edit_attr', [App\Http\Controllers\Admin\DashboardController::class, 'edit_attr'])->name('admin.edit_attr');
    Route::get('/get_attr', [App\Http\Controllers\Admin\DashboardController::class, 'get_attr'])->name('admin.get_attr');
    Route::get('/get_complex_id', [App\Http\Controllers\Admin\DashboardController::class, 'get_complex_id'])->name('admin.get_complex_id');
    Route::post('/edit_value_attr', [App\Http\Controllers\Admin\DashboardController::class, 'edit_value_attr'])->name('admin.edit_value_attr');
    Route::post('/remove_attr', [App\Http\Controllers\Admin\DashboardController::class, 'remove_attr'])->name('admin.remove_attr');
    Route::post('/create_attr_value', [App\Http\Controllers\Admin\DashboardController::class, 'create_attr_value'])->name('admin.create_attr_value');
    Route::get('/search_element', [App\Http\Controllers\Admin\DashboardController::class, 'search_element'])->name('admin.search_element');
    Route::get('/search_attributes_int', [App\Http\Controllers\Admin\DashboardController::class, 'search_attributes_int'])->name('admin.search_attributes_int');
    Route::get('/search_attributes_float', [App\Http\Controllers\Admin\DashboardController::class, 'search_attributes_float'])->name('admin.search_attributes_float');
    Route::get('/search_attributes_double', [App\Http\Controllers\Admin\DashboardController::class, 'search_attributes_double'])->name('admin.search_attributes_double');

    
    
       
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
