<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptTool extends Model
{
    protected $fillable = ['name'];

    public function promptToolTaggings()
    {
        return $this->hasMany(PromptToolTagging::class);
    }
}
