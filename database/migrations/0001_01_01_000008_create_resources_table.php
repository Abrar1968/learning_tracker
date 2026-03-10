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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
            $table->enum('resource_type', ['file', 'link', 'note', 'video', 'voice', 'code', 'flashcard_deck']);
            
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->mediumText('content')->nullable();
            
            $table->string('file_path', 500)->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            
            $table->integer('duration_sec')->nullable();
            $table->string('url', 2000)->nullable();
            
            // Open Graph
            $table->string('og_title', 255)->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image', 500)->nullable();
            $table->string('og_domain', 100)->nullable();
            
            $table->string('language', 50)->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->integer('order_index')->default(0);
            
            $table->timestamps();
            
            $table->index(['topic_id', 'resource_type']);
            $table->index(['topic_id', 'is_favorite']);
            $table->fullText(['title', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
