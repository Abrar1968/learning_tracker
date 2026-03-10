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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roadmap_id')->constrained('roadmaps')->cascadeOnDelete();
            $table->foreignId('phase_id')->nullable()->constrained('roadmap_phases')->nullOnDelete();
            // Parent topic relationship (self-referencing)
            $table->foreignId('parent_topic_id')->nullable()->constrained('topics')->nullOnDelete();
            
            $table->string('title', 255);
            $table->mediumText('description')->nullable();
            
            $table->decimal('estimated_hours', 6, 2);
            $table->decimal('actual_hours', 6, 2)->default(0);
            
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->tinyInteger('priority')->default(2); // 1 to 4
            $table->integer('order_index')->default(0);
            $table->unsignedTinyInteger('weight')->default(1);
            
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'on_hold', 'skipped'])->default('not_started');
            
            $table->tinyInteger('quality_rating')->nullable();
            $table->tinyInteger('confidence_level')->nullable();
            
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->date('due_date')->nullable();
            
            $table->timestamps();
            
            $table->index(['roadmap_id', 'order_index']);
            $table->index(['roadmap_id', 'status']);
            $table->index('parent_topic_id');
            $table->index('phase_id');
            $table->index('scheduled_date');
            $table->fullText(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
