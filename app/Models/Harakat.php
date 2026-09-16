<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harakat extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'symbol',
        'sound',
        'description',
        'order',
        'audio_url',
    ];
}
