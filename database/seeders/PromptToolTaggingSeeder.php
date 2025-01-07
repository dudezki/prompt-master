<?php

namespace Database\Seeders;

use App\Models\Prompt;
use App\Models\PromptTool;
use App\Models\PromptToolTagging;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromptToolTaggingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // loop through the prompts and randomly assign tags
        foreach (Prompt::all() as $prompt) {
            $tags = PromptTool::inRandomOrder()->limit(rand(1, 3))->get();
            PromptToolTagging::create([
                'prompt_id' => $prompt->id,
                'prompt_tool_id' => $tags->first()->id,
            ]);
        }
    }
}
