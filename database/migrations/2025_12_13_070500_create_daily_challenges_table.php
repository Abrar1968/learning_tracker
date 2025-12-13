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
        Schema::create('daily_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('challenge_date');
            $table->string('type'); // 'complete_resource', 'study_time', 'complete_topic', 'streak_bonus'
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('requirements'); // e.g., {"count": 3, "type": "article"}
            $table->json('progress')->nullable(); // Track current progress
            $table->integer('xp_reward')->default(50);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'challenge_date', 'type']);
            $table->index(['user_id', 'challenge_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_challenges');
    }
};
