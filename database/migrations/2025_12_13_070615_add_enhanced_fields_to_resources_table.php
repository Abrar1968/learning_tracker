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
        Schema::table('resources', function (Blueprint $table) {
            // Quality ratings
            $table->decimal('rating', 2, 1)->nullable()->after('completed_at'); // 1-5 stars
            $table->string('difficulty')->nullable()->after('rating'); // beginner, intermediate, advanced

            // Enhanced time tracking
            $table->integer('actual_duration')->nullable()->after('difficulty'); // Minutes spent

            // Source/author info
            $table->string('author')->nullable()->after('actual_duration');
            $table->string('source')->nullable()->after('author'); // Platform name

            // Priority for ordering
            $table->integer('priority')->default(0)->after('source');

            // Notes/highlights
            $table->text('notes')->nullable()->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn([
                'rating',
                'difficulty',
                'actual_duration',
                'author',
                'source',
                'priority',
                'notes',
            ]);
        });
    }
};
