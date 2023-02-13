<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RecruitmentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MatterController;
use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\NoticeController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function() {
    Route::post('login', [AuthController::class, 'signIn']);
    Route::post('register', [AuthController::class, 'signUp']);
});
