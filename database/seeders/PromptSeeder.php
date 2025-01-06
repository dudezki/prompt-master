<?php

namespace Database\Seeders;

use App\Models\Prompt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prompts = [
            ['category_id' => 1, 'title' => 'Example Prompt 1', 'description' => 'This is an example prompt for text-to-image.', 'created_by' => 1, 'updated_by' => 1],
            ['category_id' => 2, 'title' => 'Example Prompt 2', 'description' => 'This is an example prompt for image-to-image.', 'created_by' => 1, 'updated_by' => 1],
            ['category_id' => 3, 'title' => 'Example Prompt 3', 'description' => 'This is an example prompt for text-to-video.', 'created_by' => 1, 'updated_by' => 1],
            ['category_id' => 4, 'title' => 'Example Prompt 4', 'description' => 'This is an example prompt for image-to-video.', 'created_by' => 1, 'updated_by' => 1],
        ];

        foreach ($prompts as $prompt) {
            Prompt::create($prompt);
        }
    }
}
