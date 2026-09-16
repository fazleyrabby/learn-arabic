<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harakat extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'name_bn',
        'symbol',
        'sound',
        'sound_bn',
        'description',
        'description_bn',
        'order',
        'audio_url',
    ];
}
