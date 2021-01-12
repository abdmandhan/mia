<?php

use App\Models\CourseTaskQuestion;
use App\Models\CourseTeacher;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $date_now = date_format(date_create(now()), 'Y-m-d H:i:s');

    return $date_now;
    return response()->json(CourseTeacher::with([
        'teacher.user_teacher.golongan',
        'teacher.user_teacher.position',
        'teacher.user_teacher.education',
    ])->where('course_id', 2)->get());
});


Route::get('/v/{any}', function () {
    return view('welcome');
})->where('any', '.*')->name('v');
