<?php

namespace App\Models;


class Transaction extends Base
{
    public function transaction_status()
    {
        return $this->belongsTo(TransactionStatus::class, 'transaction_status_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
