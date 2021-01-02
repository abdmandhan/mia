<?php

namespace App\Models;

class CourseTaskStudent extends Base
{
    public function course_task()
    {
        return $this->belongsTo(CourseTask::class, 'course_task_id');
    }
}
