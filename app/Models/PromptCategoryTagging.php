<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptCategoryTagging extends Model
{
    protected $fillable = [
        'prompt_id',
        'category_id',
    ];

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }

    public function category()
    {
        return $this->belongsTo(PromptCategory::class);
    }
}
