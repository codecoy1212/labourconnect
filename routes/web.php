<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginOutController;
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

Route::get('/', function(){
    return redirect('login');
});

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
Route::get('/jobs/show/user/role',[JobController::class,'show_user_role']);
Route::get('/jobs/collection/show',[JobController::class,'fetch_jobs']);
Route::get('/jobs/collection/show/completed',[JobController::class,'fetch_jobs_completed']);
Route::put('/jobs/collection/show',[JobController::class,'mark_complete']);
Route::get('/jobs/completed',[JobController::class,'completed'])->name('cjob');
Route::get('/jobs/completed/show/{id}',[JobController::class,'completed_show'])->name('sjob');

Route::get('/login',[LoginOutController::class,'index']);
Route::post('/login',[LoginOutController::class,'loggingIn'])->name('log');
Route::get('/logout',[LoginOutController::class,'logged_out'])->name('logo');
Route::get('/show_pdf',[MainController::class,'show_pdf']);
Route::get('/show_csv',[MainController::class,'show_csv']);
Route::get('/export_csv',[MainController::class,'export_csv']);
Route::get('/get_companies_locations',[MainController::class,'new_fun_part_1']);
