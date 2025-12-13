<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicDependency extends Model
{
    protected $fillable = [
        'topic_id',
        'depends_on_topic_id',
        'is_required',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function dependsOn(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'depends_on_topic_id');
    }
}
