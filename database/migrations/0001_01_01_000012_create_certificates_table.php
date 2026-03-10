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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('roadmap_id')->constrained('roadmaps')->cascadeOnDelete();
            
            $table->string('certificate_number', 50)->unique();
            $table->timestamp('issued_at');
            
            $table->integer('total_topics');
            $table->decimal('total_learning_hours', 8, 2);
            $table->json('topics_summary');
            
            $table->decimal('average_quality', 3, 2)->nullable();
            
            $table->enum('template_type', ['classic', 'modern', 'minimalist', 'dark', 'neon'])->default('modern');
            $table->string('accent_color', 7)->default('#6366F1');
            
            $table->string('blockchain_hash', 64)->nullable();
            $table->boolean('blockchain_anchored')->default(false);
            
            $table->string('file_path_pdf', 500)->nullable();
            $table->string('file_path_png', 500)->nullable();
            $table->string('linkedin_post_id', 255)->nullable();
            
            $table->boolean('is_revoked')->default(false);
            
            $table->timestamps();
            
            $table->index(['user_id', 'issued_at']);
            $table->index('roadmap_id');
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
