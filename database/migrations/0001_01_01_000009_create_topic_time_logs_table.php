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
        Schema::create('topic_time_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->decimal('duration_hours', 5, 2);
            $table->text('notes')->nullable();
            $table->date('logged_date');
            
            $table->timestamps();
            
            $table->index(['user_id', 'logged_date']);
        });
        
        Schema::create('topic_reflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->text('content');
            $table->tinyInteger('understanding_score')->nullable(); // 1-5
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_reflections');
        Schema::dropIfExists('topic_time_logs');
    }
};
