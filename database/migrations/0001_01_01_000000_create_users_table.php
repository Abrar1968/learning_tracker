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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->unique();
            $table->string('email')->unique();
            $table->string('password')->nullable(); // Nullable for OAuth-only users
            $table->string('full_name', 100)->nullable();
            $table->string('headline', 160)->nullable();
            $table->string('profession', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('location', 100)->nullable();
            $table->string('website')->nullable();
            $table->string('github_username', 100)->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('twitter_username', 100)->nullable();
            $table->string('profile_picture', 500)->nullable();
            $table->string('cover_image', 500)->nullable();
            
            // Preferences
            $table->string('timezone', 60)->default('UTC');
            $table->string('locale', 10)->default('en');
            $table->enum('theme', ['system', 'light', 'dark'])->default('system');
            $table->string('accent_color', 20)->default('#6366F1');
            $table->decimal('available_hours_week', 4, 1)->default(10.0);
            
            $table->boolean('is_mentor')->default(false);
            $table->boolean('is_public')->default(false);
            
            // Security & Auth state
            $table->string('two_factor_secret')->nullable();
            $table->boolean('two_factor_confirmed')->default(false);
            $table->boolean('onboarding_completed')->default(false);
            $table->timestamp('last_active_at')->nullable();
            
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['is_public', 'is_mentor']);
            $table->index('last_active_at');
            // A fulltext index for searches (if supported by DB engine)
            $table->fullText(['username', 'full_name', 'profession', 'bio']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
