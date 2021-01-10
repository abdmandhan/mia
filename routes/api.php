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
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TryoutController;
use App\Http\Controllers\Api\TryoutQuestionController;
use App\Http\Controllers\Api\UserController;
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
    Route::post('update', [AuthController::class, 'update']);
    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::post('discussion/reply', [DiscussionController::class, 'storeReply']);
    Route::delete('discussion/reply/{id}', [DiscussionController::class, 'destroyReply']);

    //page
    Route::get('dashboard', [PageController::class, 'dashboard']);
    Route::get('teacher', [PageController::class, 'teacher']);
    Route::get('feedback', [PageController::class, 'feedback']);
    Route::post('feedback', [PageController::class, 'feedbackScore']);
    Route::get('feedback/{feedback_id}', [PageController::class, 'feedbackDetail']);

    Route::get('s-transaction', [PageController::class, 'sTransaction']);
    Route::get('s-transaction/{transaction_id}', [PageController::class, 'sTransactionDetail']);

    Route::get('s-course', [PageController::class, 'sCourse']);
    Route::get('s-course/{course_id}', [PageController::class, 'sCourseDetail']);
    Route::post('s-course', [PageController::class, 'sCourseJoin']);

    Route::get('s-learning', [PageController::class, 'slearning']);
    Route::get('s-learning/{learning_id}', [PageController::class, 'sLearningDetail']);
    Route::get('s-learning/{task_id}/task', [PageController::class, 'sLearningTask']);
    Route::post('s-learning', [PageController::class, 'sLearningStart']);
    Route::post('s-learning/task', [PageController::class, 'sLearningFinish']);

    Route::resource('discussion', DiscussionController::class);
    Route::resource('user', UserController::class);
    Route::resource('transaction', TransactionController::class);
    Route::resource('tryout', TryoutController::class);
    Route::resource('tryout-question', TryoutQuestionController::class);
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
