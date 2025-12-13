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
        Schema::create('review_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('topic_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('resource_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('next_review_date');
            $table->date('last_review_date')->nullable();
            $table->integer('interval_days')->default(1); // SM-2 interval
            $table->decimal('easiness_factor', 4, 2)->default(2.5); // SM-2 EF
            $table->integer('repetition_count')->default(0);
            $table->integer('quality_score')->nullable(); // 0-5 rating on last review
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['user_id', 'next_review_date']);
            $table->index(['user_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_schedules');
    }
};
