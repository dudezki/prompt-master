<?php

namespace Database\Seeders;

use App\Models\Prompt;
use App\Models\PromptCategory;
use App\Models\PromptCategoryTagging;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromptCategoryTaggingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $prompts = Prompt::all();
        $categories = PromptCategory::all();

        foreach ($prompts as $prompt) {
            $randomCategory = $categories->random();

            PromptCategoryTagging::create([
                'prompt_id' => $prompt->id,
                'category_id' => $randomCategory->id,
            ]);
        }
    }
}
