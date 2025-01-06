<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'visibility',
        'status',
        'created_by',
        'updated_by',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(PromptCategory::class);
    }
}
