<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'roadmap_id',
        'user_id',
        'certificate_number',
        'verification_code',
        'issue_date',
        'file_path',
        'total_hours',
        'completion_percentage',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'completion_percentage' => 'decimal:2',
        ];
    }

    // Relationships
    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper Methods
    public static function generateCertificateNumber(): string
    {
        return 'CERT-' . date('Y') . '-' . strtoupper(Str::random(8));
    }

    public static function generateVerificationCode(): string
    {
        return strtoupper(Str::random(16));
    }

    public function getVerificationUrl(): string
    {
        return route('certificates.verify', $this->verification_code);
    }
}
