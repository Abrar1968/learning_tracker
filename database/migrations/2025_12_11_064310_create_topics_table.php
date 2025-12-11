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
            $table->foreignId('roadmap_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('topics')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->integer('order')->default(0);
            $table->integer('estimated_hours')->default(0);
            $table->integer('actual_hours')->default(0);
            $table->decimal('weightage', 5, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('roadmap_id');
            $table->index('parent_id');
            $table->index('status');
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
