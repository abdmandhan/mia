<?php

namespace App\Models;

class CourseTaskStudent extends Base
{
    public function course_task()
    {
        return $this->belongsTo(CourseTask::class, 'course_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
