<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    protected $fillable = [
        'title',
        'positive_prompt',
        'negative_prompt',
        'visibility',
        'status',
        'created_by',
        'updated_by',
        'status',
    ];

    protected $appends = ['author', 'author_avatar'];


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

    public function tools()
    {
        return $this->hasMany(PromptToolTagging::class, 'prompt_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getAuthorAttribute() {
        return $this->user->username;
    }

    public function getAuthorNameAttribute() {
        return $this->user->name;
    }

    public function getAuthorAvatarAttribute() {
        return $this->user->avatar;
    }

    public function cards()
    {
        return $this->hasMany(PromptCard::class);
    }

    public function ai_model()
    {
        return $this->belongsTo(AiModel::class, 'model_id');
    }
}
