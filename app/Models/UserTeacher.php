<?php

namespace App\Models;


class UserTeacher extends Base
{
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
