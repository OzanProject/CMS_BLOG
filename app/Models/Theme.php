<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['name', 'path', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
