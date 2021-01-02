<?php

namespace App\Models;


class UserStudent extends Base
{
    protected $casts = [
        'grade_id'   => 'integer'
    ];
}
