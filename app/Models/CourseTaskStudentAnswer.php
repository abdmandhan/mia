<?php

namespace App\Models;

class CourseTaskStudentAnswer extends Base
{
    public function question()
    {
        return $this->belongsTo(CourseTaskQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(CourseTaskAnswer::class, 'answer_id');
    }
}
