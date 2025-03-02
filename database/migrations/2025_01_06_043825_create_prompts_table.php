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
        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('positive_prompt')->nullable();
            $table->text('negative_prompt')->nullable();
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');
            $table->foreignId('model_id')->nullable()->constrained('ai_models');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->boolean('is_nsfw')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prompts');
    }
};
