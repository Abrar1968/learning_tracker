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
        Schema::table('users', function (Blueprint $table) {
            // Profile fields
            $table->string('username')->nullable()->unique()->after('name');
            $table->text('bio')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('bio');
            $table->boolean('is_public')->default(false)->after('avatar');

            // User preferences (JSON for flexibility)
            $table->json('preferences')->nullable()->after('is_public');

            // Gamification fields
            $table->integer('xp')->default(0)->after('preferences');
            $table->integer('level')->default(1)->after('xp');
            $table->integer('current_streak')->default(0)->after('level');
            $table->integer('longest_streak')->default(0)->after('current_streak');
            $table->date('last_activity_date')->nullable()->after('longest_streak');

            // Timezone for proper scheduling
            $table->string('timezone')->default('UTC')->after('last_activity_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'bio',
                'avatar',
                'is_public',
                'preferences',
                'xp',
                'level',
                'current_streak',
                'longest_streak',
                'last_activity_date',
                'timezone',
            ]);
        });
    }
};
