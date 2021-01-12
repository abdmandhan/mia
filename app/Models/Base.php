<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Base extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    protected static function booted()
    {
        static::saving(function ($data) {
            $tz = 'Asia/Jakarta';
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            if (!$data->created_at) {
                $data->created_at = $dt->format('d.m.Y, H:i:s');
            }
        });
    }
}
