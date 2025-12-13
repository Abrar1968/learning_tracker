<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Default preferences structure
     */
    public const DEFAULT_PREFERENCES = [
        'theme' => 'system', // light, dark, system
        'keyboard_shortcuts' => true,
        'email_notifications' => true,
        'weekly_digest' => true,
        'pomodoro_duration' => 25,
        'short_break_duration' => 5,
        'long_break_duration' => 15,
        'daily_goal_hours' => 2,
        'sound_enabled' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_public' => 'boolean',
            'preferences' => 'array',
            'last_activity_date' => 'date',
        ];
    }

    /**
     * Get a specific preference value with fallback to default
     */
    public function getPreference(string $key, mixed $default = null): mixed
    {
        $preferences = $this->preferences ?? [];
        return $preferences[$key] ?? self::DEFAULT_PREFERENCES[$key] ?? $default;
    }

    /**
     * Set a specific preference value
     */
    public function setPreference(string $key, mixed $value): void
    {
        $preferences = $this->preferences ?? [];
        $preferences[$key] = $value;
        $this->preferences = $preferences;
        $this->save();
    }

    /**
     * Check if dark mode is enabled
     */
    public function isDarkMode(): bool
    {
        return $this->getPreference('theme') === 'dark';
    }

    /**
     * Get the user's display name (username or name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->username ?? $this->name;
    }

    /**
     * Get initials for avatar fallback
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    // Relationships
    public function roadmaps(): HasMany
    {
        return $this->hasMany(Roadmap::class);
    }

    public function topics(): HasManyThrough
    {
        return $this->hasManyThrough(Topic::class, Roadmap::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function topicProgress(): HasMany
    {
        return $this->hasMany(TopicProgress::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function dailyChallenges(): HasMany
    {
        return $this->hasMany(DailyChallenge::class);
    }

    public function weeklyGoals(): HasMany
    {
        return $this->hasMany(WeeklyGoal::class);
    }

    public function focusSessions(): HasMany
    {
        return $this->hasMany(FocusSession::class);
    }

    public function reviewSchedules(): HasMany
    {
        return $this->hasMany(ReviewSchedule::class);
    }
}
