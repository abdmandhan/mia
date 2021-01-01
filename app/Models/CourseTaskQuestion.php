<?php

namespace App\Models;

class CourseTaskQuestion extends Base
{
    public function question_type()
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function answer()
    {
        return $this->hasMany(CourseTaskAnswer::class);
    }
}
