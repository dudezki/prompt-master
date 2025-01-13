<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptToolTagging extends Model
{

    protected $table = 'prompt_tool_tagging';
    protected $fillable = ['prompt_id', 'prompt_tool_id'];

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }

    public function tool()
    {
        return $this->belongsTo(PromptTool::class, 'prompt_tool_id');
    }
}
