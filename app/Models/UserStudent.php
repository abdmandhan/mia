<?php

namespace App\Models;


class UserStudent extends Base
{
    protected $casts = [
        'id'            => 'integer',
        'grade_id'   => 'integer'
    ];
}
