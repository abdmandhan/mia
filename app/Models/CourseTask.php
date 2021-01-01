<?php

namespace App\Models;

class CourseTask extends Base
{
    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }
}
