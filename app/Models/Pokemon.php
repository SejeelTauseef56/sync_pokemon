<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $fillable = [
        'external_id',
        'name',
        'height',
        'weight',
        'base_experience',
        'api_url',
    ];
}
