<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\Auth;

class Tryout extends Base
{
    protected $appends = [
        'question_count',
        'timestamp'
    ];

    protected $casts = [
        'id'            => 'integer',
        'is_show_review'    => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'date_start'    => 'datetime:Y-m-d',
        'date_finish'    => 'datetime:Y-m-d',
    ];

    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function getQuestionCountAttribute()
    {
        return $this->tryout_question()->get()->count();
    }

    public function tryout_question()
    {
        return $this->hasMany(TryoutQuestion::class);
    }

    public function tryout_student()
    {
        return $this->hasMany(TryoutStudent::class);
    }

    public function getTimestampAttribute()
    {
        //hitung udah berapa lama dari start_time sampe skrng
        $init1 = new DateTime($this->time);
        $start = date('H:i:s', strtotime($this->date_start));
        $init2 = new DateTime($start);

        $interval = $init1->diff($init2);

        $time_seconds = convertTimeToSeconds($interval->format('%H:%i:%s'));

        return $time_seconds * 1000;
    }

    public function getStudentAssignAttribute()
    {
        return $this->tryout_student()->with([
            'tryout_student_answer.question',
            'tryout_student_answer.answer',
        ])->where('user_id', Auth::id())->first();
    }
}
