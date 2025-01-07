<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prompt_tool_tagging', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_id')->constrained('prompts');
            $table->foreignId('prompt_tool_id')->constrained('prompt_tools');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompt_tool_tagging');
    }
};
