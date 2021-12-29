<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


Route::post('/roles/add',[RoleController::class,'add_role']);
Route::get('/roles/show',[RoleController::class,'show_roles']);
Route::get('/roles/show/specific',[RoleController::class,'show_role']);
Route::put('/roles/edit',[RoleController::class,'edit_role']);
Route::delete('/roles/delete',[RoleController::class,'del_role']);
Route::get('/roles/search',[RoleController::class,'search_role']);

Route::post('/companies/add',[CompanyController::class,'add_company']);
Route::get('/companies/show',[CompanyController::class,'show_companies']);
Route::get('/companies/show/specific',[CompanyController::class,'show_company']);
Route::put('/companies/edit',[CompanyController::class,'edit_company']);
Route::delete('/companies/delete',[CompanyController::class,'del_company']);
Route::get('/companies/search',[CompanyController::class,'search_company']);

Route::post('/users/add',[UserController::class,'add_user']);
Route::get('/users/show',[UserController::class,'show_users']);
Route::get('/users/show/specific',[UserController::class,'show_user']);
Route::put('/users/edit',[UserController::class,'edit_user']);
Route::delete('/users/delete',[UserController::class,'del_user']);
Route::get('/users/search',[UserController::class,'search_user']);

Route::post('/jobs/add',[JobController::class,'add_job']);
Route::get('/jobs/show/{id}',[JobController::class,'show_job'])->name('ujob');
Route::get('/jobs/show/specific/detail',[JobController::class,'show_job_det']);
Route::put('/jobs/edit',[JobController::class,'edit_job']);
Route::delete('/jobs/delete',[JobController::class,'del_job']);
Route::get('/jobs/search',[JobController::class,'search_user']);
