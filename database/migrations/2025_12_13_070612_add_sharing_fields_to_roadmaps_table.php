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
        Schema::table('roadmaps', function (Blueprint $table) {
            // Sharing & forking
            $table->boolean('is_public')->default(false)->after('completed_topics');
            $table->foreignId('forked_from')->nullable()->after('is_public')->constrained('roadmaps')->nullOnDelete();
            $table->integer('fork_count')->default(0)->after('forked_from');

            // Template reference
            $table->foreignId('template_id')->nullable()->after('fork_count')->constrained('roadmap_templates')->nullOnDelete();

            // View preference
            $table->string('view_type')->default('list')->after('template_id'); // list, kanban, timeline, graph

            // Color/icon customization
            $table->string('icon')->nullable()->after('view_type');
            $table->string('color')->nullable()->after('icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roadmaps', function (Blueprint $table) {
            $table->dropForeign(['forked_from']);
            $table->dropForeign(['template_id']);
            $table->dropColumn([
                'is_public',
                'forked_from',
                'fork_count',
                'template_id',
                'view_type',
                'icon',
                'color',
            ]);
        });
    }
};
