<?php

namespace App\Models;


class TryoutQuestion extends Base
{
    public function tryout_answer()
    {
        return $this->hasMany(TryoutAnswer::class, 'tryout_question_id');
    }
}
