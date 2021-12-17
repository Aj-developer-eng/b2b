<?php

use App\Http\Controllers\Emp\EmployeeDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\frontend\EmployeeController;
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



Route::get("removecache",function (){
\Illuminate\Support\Facades\Artisan::call('route:cache');
\Illuminate\Support\Facades\Artisan::call('route:clear');
\Illuminate\Support\Facades\Artisan::call('config:cache');
\Illuminate\Support\Facades\Artisan::call('config:clear');
\Illuminate\Support\Facades\Artisan::call('optimize');
});



/*
|--------------------------------------------------------------------------
| written routes by jaMshAid ChEeNa
|--------------------------------------------------------------------------
*/

Route::group(['middleware'=>'emp_middleware'],function(){
Route::get('/',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'index']);
});
Route::group(['prefix'=>'dashboard','middleware'=>'emp_middleware'],function(){
    Route::get('/location',[EmployeeDashboardController::class,'mapview'])->name('location');
Route::get('/',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'index'])->name('dashboard');
Route::get('/clock_in',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'clock_in'])->name('clock_in');
Route::get('/clock_out',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'clock_out'])->name('clock_out');
Route::get('/attendance',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'attendance']);
Route::get('/update_profile',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'update_profile']);
Route::post('/personal_information',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'personal_information']);
Route::post('/change_picture',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'change_picture']);
Route::post('/change_password',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'change_password']);
Route::get('/accepted_task/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'accepted_task']);
Route::get('/rejected_task/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'rejected_task']);
Route::get('/task_completed/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'task_completed']);
Route::get('/emp_task',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'emp_task']);
Route::get('/employee_task/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'employee_task']);
Route::get('/emp_leaves',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'emp_leaves']);
Route::post('/leaves/submit',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'store']);


Route::get('/emp_leaves_paid/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'emp_leaves_paid']);
Route::post('/emp_leaves_paid_submit/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'emp_leaves_paid_submit']);

Route::get('/leaves_request_accepted/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'leaves_request_accepted']);
Route::get('/leaves_request_rejected/{id}',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'leaves_request_rejected']);

    Route::get('/save-location',[App\Http\Controllers\Emp\EmployeeDashboardController::class,'save_location']);
    Route::get('/my_lead',[App\Http\Controllers\frontend\EmployeeController::class,'assigned_lead']);
Route::get('/changeStatus1',[App\Http\Controllers\frontend\EmployeeController::class,'changeStatus']);
});
Route::get('/login',  [App\Http\Controllers\frontend\EmployeeController::class,'employee_login'])->name('employee_login');
Route::post('/login',  [App\Http\Controllers\frontend\EmployeeController::class,'employee_login_submit'])->name('employee_login_submit');
Route::get('/logout',  [App\Http\Controllers\frontend\EmployeeController::class,'employee_logout'])->name('employee_logout');


Route::post('/mark-as-read', [App\Http\Controllers\Emp\EmployeeDashboardController::class,'markNotification'])->name('markNotification');











//to update ip
Route::post('updateip/{id}',[EmployeeDashboardController::class,'update_ip1']);
//to get travel record
Route::post('travel',[EmployeeDashboardController::class,'update_travel']);




