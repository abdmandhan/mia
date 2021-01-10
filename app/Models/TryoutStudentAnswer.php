<?php

namespace App\Models;


class TryoutStudentAnswer extends Base
{
    public function question()
    {
        return $this->belongsTo(TryoutQuestion::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(TryoutAnswer::class, 'answer_id');
    }
}
