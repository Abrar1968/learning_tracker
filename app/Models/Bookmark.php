<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
        'folder',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to filter by folder
     */
    public function scopeInFolder($query, ?string $folder)
    {
        if ($folder === null) {
            return $query->whereNull('folder');
        }
        return $query->where('folder', $folder);
    }

    /**
     * Get all unique folders for a user
     */
    public static function getFoldersForUser(int $userId): array
    {
        return self::where('user_id', $userId)
            ->whereNotNull('folder')
            ->distinct()
            ->pluck('folder')
            ->toArray();
    }
}
