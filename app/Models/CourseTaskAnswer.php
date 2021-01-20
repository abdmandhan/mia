<?php

namespace App\Models;


class CourseTaskAnswer extends Base
{
    protected $casts = [
        'id'            => 'integer',

        'is_true'   => 'boolean'
    ];
}
