<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptCategory extends Model
{
    protected $fillable = [
        'code',
        'description',
        'color',
        'svg_icon',
        'status',
    ];
}
