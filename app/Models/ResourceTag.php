<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'tag_name',
    ];

    // Relationships
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    // Scopes
    public function scopeByTag($query, string $tag)
    {
        return $query->where('tag_name', $tag);
    }
}
