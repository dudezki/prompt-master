<?php

namespace Database\Seeders;

use App\Models\PromptTool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromptToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = ['Tool 1', 'Tool 2', 'Tool 3'];

        foreach ($tools as $tool) {
            PromptTool::create(['name' => $tool]);
        }
    }
}
