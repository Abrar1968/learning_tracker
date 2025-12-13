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
        Schema::table('topics', function (Blueprint $table) {
            // Skill categorization for radar chart
            $table->string('skill_category')->nullable()->after('weightage'); // frontend, backend, database, devops, etc.

            // Rich notes
            $table->longText('notes')->nullable()->after('skill_category');

            // Color/icon for visualization
            $table->string('icon')->nullable()->after('notes');
            $table->string('color')->nullable()->after('icon');

            // Position for graph view
            $table->integer('position_x')->nullable()->after('color');
            $table->integer('position_y')->nullable()->after('position_x');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn([
                'skill_category',
                'notes',
                'icon',
                'color',
                'position_x',
                'position_y',
            ]);
        });
    }
};
