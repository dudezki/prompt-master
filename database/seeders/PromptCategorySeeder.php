<?php

namespace Database\Seeders;

use App\Models\PromptCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromptCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['code' => 'text-to-image', 'description' => 'Text to Image', 'color' => '#FF5733', 'svg_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="2" fill="{color}"/><path d="M8 12H16V14H8V12ZM8 10H16V8H8V10ZM12 16H8V18H12V16Z" fill="white"/><text x="12" y="12" text-anchor="middle" fill="white" font-size="10" font-family="Arial" dy=".3em">T</text></svg>', 'status' => 'active'],
            ['code' => 'image-to-image', 'description' => 'Image to Image', 'color' => '#33FF57', 'svg_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zm-2 0H5V5h14v14zM8.5 11.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" fill="{color}"/></svg>', 'status' => 'active'],
            ['code' => 'text-to-video', 'description' => 'Text to Video', 'color' => '#3357FF', 'svg_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 14H5V7h14v10zm-7-9l5 4-5 4V8z" fill="{color}"/></svg>', 'status' => 'active'],
            ['code' => 'image-to-video', 'description' => 'Image to Video', 'color' => '#FF33A1', 'svg_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 14H5V7h14v10zm-7-9l5 4-5 4V8z" fill="{color}"/></svg>', 'status' => 'active'],
        ];

        foreach ($categories as $category) {
            $category['svg_icon'] = str_replace('{color}', $category['color'], $category['svg_icon']);
            PromptCategory::create($category);
        }
    }
}
