<?php

namespace App\Models;

class Course extends Base
{
    protected $casts = [
        'is_premium'    => 'boolean'
    ];

    public function getCourseTypeNameAttribute()
    {
        return $this->course_type()->first()->name;
    }

    public function getGradeNameAttribute()
    {
        return $this->grade()->first()->name;
    }

    public function course_content()
    {
        return $this->hasMany(CourseContent::class, 'course_id');
    }

    public function course_task()
    {
        return $this->hasMany(CourseTask::class, 'course_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function course_type()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function course_teacher()
    {
        return $this->hasMany(CourseTeacher::class, 'course_id');
    }

    public function course_task_student()
    {
        return $this->hasMany(CourseTaskStudent::class, 'course_id');
    }
}
