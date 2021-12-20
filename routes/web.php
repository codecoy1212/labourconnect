<?php

use App\Http\Controllers\MainController;
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

Route::get('/dashboard',[MainController::class,'index'])->name('dash');
Route::get('/jobs',[MainController::class,'jobs'])->name('jobs');
Route::get('/jobs/new_job',[MainController::class,'new_job'])->name('njob');
Route::get('/users',[MainController::class,'users'])->name('aser');
Route::get('/companies',[MainController::class,'companies'])->name('cies');
Route::get('/roles',[MainController::class,'roles'])->name('oles');
Route::get('/reports',[MainController::class,'reports'])->name('orts');
