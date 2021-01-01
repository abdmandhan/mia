<?php

namespace App\Models;

class DiscussionReply extends Base
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('name');
    }
}
