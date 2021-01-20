<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class TryoutStudent extends Base
{
    public function tryout_student_answer()
    {
        return $this->hasMany(TryoutStudentAnswer::class, 'tryout_id', 'tryout_id')->where('user_id', Auth::id());
    }

    public function tryout()
    {
        return $this->belongsTo(Tryout::class, 'tryout_id');
    }
}
