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
            $table->foreignId('roadmap_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('certificate_number')->unique();
            $table->string('verification_code')->unique();
            $table->date('issue_date');
            $table->string('file_path')->nullable();
            $table->integer('total_hours')->default(0);
            $table->decimal('completion_percentage', 5, 2)->default(100);
            $table->timestamps();

            $table->index('roadmap_id');
            $table->index('user_id');
            $table->index('verification_code');
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
