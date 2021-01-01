<?php

namespace App\Models;

class Discussion extends Base
{
    protected $casts = [
        'created_at'    => 'date:Y-m-d H:i:s',
        'is_done'       => 'boolean'
    ];

    public function replies()
    {
        return $this->hasMany(DiscussionReply::class, 'discuss_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }
}
