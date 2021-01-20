<?php

namespace App\Models;


class TryoutQuestion extends Base
{
    public function tryout_answer()
    {
        return $this->hasMany(TryoutAnswer::class, 'tryout_question_id');
    }

    protected $appends = [
        'true_answer'
    ];

    public function getTrueAnswerAttribute()
    {
        return $this->tryout_answer()->where('is_true', '1')->first();
    }
}
