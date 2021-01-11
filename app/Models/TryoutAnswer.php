<?php

namespace App\Models;

class TryoutAnswer extends Base
{
    protected $fillable = [
        'tryout_question_id',
        'answer',
        'is_true'
    ];
}
