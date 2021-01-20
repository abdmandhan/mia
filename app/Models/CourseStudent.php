<?php

namespace App\Models;

class CourseStudent extends Base
{
    protected $casts = [
        'id'            => 'integer',

        'is_complete'    => 'boolean'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
