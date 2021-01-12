<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Base extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = [
    //     'created_at'
    // ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    // protected static function booted()
    // {
    //     static::saving(function ($data) {
    //         if ($data->created_at) {
    //         }
    //         $data->created_at = date_format(date_create(now()), 'Y-m-d H:i:s');
    //         de([$data, Carbon::now()]);
    //     });
    // }
}
