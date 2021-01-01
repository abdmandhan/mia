<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseContentController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseTaskController;
use App\Http\Controllers\Api\CourseTaskQuestionController;
use App\Http\Controllers\Api\DiscussionController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\Resource\AnnouncementController;
use App\Http\Controllers\Api\Resource\CourseTypeController;
use App\Http\Controllers\Api\Resource\DifficultyController;
use App\Http\Controllers\Api\Resource\EducationController;
use App\Http\Controllers\Api\Resource\GolonganController;
use App\Http\Controllers\Api\Resource\GradeController;
use App\Http\Controllers\Api\Resource\PositionController;
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

    Route::post('discussion/reply', [DiscussionController::class, 'storeReply']);
    Route::delete('discussion/reply/{id}', [DiscussionController::class, 'destroyReply']);

    //page
    Route::get('dashboard', [PageController::class, 'dashboard']);
    Route::resource('discussion', DiscussionController::class);
    Route::resource('course', CourseController::class);
    Route::resource('course-teacher', CourseTeacherController::class);
    Route::resource('course-content', CourseContentController::class);
    Route::resource('course-task', CourseTaskController::class);
    Route::resource('course-task-question', CourseTaskQuestionController::class);

    //resource
    Route::resource('announcement', AnnouncementController::class);
    Route::resource('position', PositionController::class);
    Route::resource('course-type', CourseTypeController::class);
    Route::resource('difficulty', DifficultyController::class);
    Route::resource('education', EducationController::class);
    Route::resource('golongan', GolonganController::class);
    Route::resource('grade', GradeController::class);
});
