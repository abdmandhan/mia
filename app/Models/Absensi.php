<?php

namespace App\Models;

class Absensi extends Base
{
    protected $appends = [
        'start',
        'end'
    ];

    protected $casts = [
        'id'            => 'integer',

        'timed' => 'boolean'
    ];

    public function getStartAttribute()
    {
        return strtotime($this->date);
    }

    public function getEndAttribute()
    {
        return strtotime($this->date);
    }
}
