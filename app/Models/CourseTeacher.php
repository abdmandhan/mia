<?php

namespace App\Models;

class CourseTeacher extends Base
{
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
