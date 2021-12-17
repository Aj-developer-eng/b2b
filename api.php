<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apicontroller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//to handle wrong token
Route::get('login', function () {
        return response()->json(['message'=>'Token is wrong...Please enter the exact Token!']);
})->name('login');


//forget password
Route::post('forgetpassword', [Apicontroller::class,'submitForgetPassword']);
Route::get('resetpassword/{token}', [Apicontroller::class,'showResetPassword']);
Route::post('reset_passwordz', [Apicontroller::class,'submitResetPassword']);
//
Route::post('verification_mail', [Apicontroller::class,'verify_process']);


Route::post('signup_process', [Apicontroller::class,'signup_process1']);
Route::post('login_process', [Apicontroller::class,'login_process1']);

Route::group(['middleware'=>['auth:sanctum']], function (){

Route::get('logout', [Apicontroller::class,'logout1']);

});