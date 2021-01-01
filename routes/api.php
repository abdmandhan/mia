<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseContentController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseTaskController;
use App\Http\Controllers\Api\CourseTaskQuestionController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\CourseTeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Unauthorized API
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//Authorized API
Route::group([
    'middleware'    => ['auth:sanctum']
], function () {
    Route::get('verify', [AuthController::class, 'verify']);

    //page
    Route::get('dashboard', [PageController::class, 'dashboard']);
    Route::resource('course', CourseController::class);
    Route::resource('course-teacher', CourseTeacherController::class);
    Route::resource('course-content', CourseContentController::class);
    Route::resource('course-task', CourseTaskController::class);
    Route::resource('course-task-question', CourseTaskQuestionController::class);
});
