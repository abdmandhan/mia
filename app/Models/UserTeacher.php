<?php

namespace App\Models;


class UserTeacher extends Base
{
    protected $casts = [
        'id'            => 'integer',
        'golongan_id'   => 'integer',
        'education_id'   => 'integer',
        'position_id'   => 'integer'
    ];
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
