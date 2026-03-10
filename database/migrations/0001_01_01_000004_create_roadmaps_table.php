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
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('slug', 300)->unique();
            $table->mediumText('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->json('tags')->nullable();
            $table->date('target_completion_date')->nullable();
            
            $table->boolean('is_public')->default(false);
            $table->enum('visibility', ['private', 'friends', 'public'])->default('private');
            $table->enum('status', ['draft', 'active', 'completed', 'archived'])->default('active');
            
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->decimal('weighted_progress', 5, 2)->default(0);
            $table->decimal('quality_score', 5, 2)->default(0);
            $table->decimal('composite_score', 5, 2)->default(0);
            $table->decimal('total_score', 5, 2)->default(0);
            
            $table->foreignId('cloned_from_id')->nullable()->constrained('roadmaps')->nullOnDelete();
            
            $table->unsignedInteger('total_clones')->default(0);
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('total_bookmarks')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->unsignedInteger('ratings_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'status', 'updated_at']);
            $table->index(['is_public', 'status', 'composite_score']);
            $table->index(['category', 'is_public']);
            $table->fullText(['title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
