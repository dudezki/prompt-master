<?php

namespace App\Models;

use Database\Factories\PromptCardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromptCard extends Model
{
    /** @use HasFactory<PromptCardFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'file_name',
        'file_type',
        'file_size',
        'file_extension',
        'prompt_id',
        'status'
    ];

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }
}
