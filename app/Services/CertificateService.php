<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Roadmap;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CertificateService
{
    public function generateCertificate(Roadmap $roadmap, User $user): Certificate
    {
        return DB::transaction(function () use ($roadmap, $user) {
            // Check if certificate already exists
            $existing = Certificate::where('roadmap_id', $roadmap->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existing) {
                return $existing;
            }

            // Calculate total hours
            $totalHours = $roadmap->topics()->sum('actual_hours');

            $certificate = Certificate::create([
                'roadmap_id' => $roadmap->id,
                'user_id' => $user->id,
                'certificate_number' => Certificate::generateCertificateNumber(),
                'verification_code' => Certificate::generateVerificationCode(),
                'issue_date' => now(),
                'total_hours' => $totalHours,
                'completion_percentage' => $roadmap->progress_percentage,
            ]);

            activity()
                ->performedOn($certificate)
                ->withProperties([
                    'roadmap' => $roadmap->title,
                    'certificate_number' => $certificate->certificate_number,
                ])
                ->log('certificate_generated');

            return $certificate;
        });
    }

    public function verifyCertificate(string $verificationCode): ?Certificate
    {
        return Certificate::where('verification_code', $verificationCode)->first();
    }

    public function deleteCertificate(Certificate $certificate): bool
    {
        activity()
            ->performedOn($certificate)
            ->withProperties(['certificate_number' => $certificate->certificate_number])
            ->log('certificate_deleted');

        return $certificate->delete();
    }
}
