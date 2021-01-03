<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class CourseTask extends Base
{
    public function course_task_question()
    {
        return $this->hasMany(CourseTaskQuestion::class, 'course_task_id');
    }

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function course_task_student_answer()
    {
        return $this->hasMany(CourseTaskStudentAnswer::class, 'task_id')->where('user_id', Auth::id());
    }

    public function student_answer()
    {
        return $this->hasMany(CourseTaskStudentAnswer::class, 'task_id');
    }
}
