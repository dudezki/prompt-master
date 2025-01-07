<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    protected $fillable = [
        'title',
        'description',
        'visibility',
        'status',
        'created_by',
        'updated_by',
        'status',
    ];

    public function tagging()
    {
        return $this->hasMany(PromptCategoryTagging::class);
    }

    public function getCategories()
    {
        return $this->tagging->map(function($tag) {
            return $tag->category;
        });
    }

    // Other model properties and methods

    public function toolTagging()
    {
        return $this->hasMany(PromptToolTagging::class, 'prompt_tool_taggings', 'prompt_id', 'prompt_tool_id');
    }
}
