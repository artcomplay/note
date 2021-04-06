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
    Route::post('/create_subject', [App\Http\Controllers\Admin\DashboardController::class, 'create_subject'])->name('admin.create_subject');
    Route::get('/category_data', [App\Http\Controllers\Admin\DashboardController::class, 'category_data'])->name('admin.category_data');
    Route::post('/create_attribute', [App\Http\Controllers\Admin\DashboardController::class, 'create_attribute'])->name('admin.create_attribute');
    Route::get('/attributes_data', [App\Http\Controllers\Admin\DashboardController::class, 'attributes_data'])->name('admin.attributes_data');
    Route::post('/edit_element', [App\Http\Controllers\Admin\DashboardController::class, 'edit_element'])->name('admin.edit_element');
    Route::get('/subject_data', [App\Http\Controllers\Admin\DashboardController::class, 'subject_data'])->name('admin.subject_data');
    Route::post('/create_element', [App\Http\Controllers\Admin\DashboardController::class, 'create_element'])->name('admin.create_element');
    Route::get('/get_section_name', [App\Http\Controllers\Admin\DashboardController::class, 'get_section_name'])->name('admin.get_section_name');
    Route::get('/get_section_id_for_cat', [App\Http\Controllers\Admin\DashboardController::class, 'get_section_id_for_cat'])->name('admin.get_section_id_for_cat');
    Route::get('/get_section_id_for_edit', [App\Http\Controllers\Admin\DashboardController::class, 'get_section_id_for_edit'])->name('admin.get_section_id_for_edit');
    Route::post('/remove_subject', [App\Http\Controllers\Admin\DashboardController::class, 'remove_subject'])->name('admin.remove_subject');
    
  
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
