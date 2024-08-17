<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WorkController;
use App\Http\Controllers\API\JobApplicationController;

Route::group(['prefix' => 'v1/auth/','middleware' => ['throttle:apiglobal']], function ($router) {

    Route::post('register', [AuthController::class,'register'])->name('register');
    Route::post('login', [AuthController::class,'login'])->name('login'); 
 
});


Route::group(['prefix' => 'v1/auth/', 'middleware' => ['auth:sanctum', 'throttle:apiglobal']], function () {

    Route::get('user', [AuthController::class,'user'])->name('user');
    Route::post('logout', [AuthController::class,'logout'])->name('logout');
    Route::get('work/search', [WorkController::class, 'search']);
    Route::resource('work', WorkController::class);

    Route::post('work/{workId}/apply', [JobApplicationController::class, 'apply']);
    Route::get('work/{workId}/applications', [JobApplicationController::class, 'applications']);
    
});





