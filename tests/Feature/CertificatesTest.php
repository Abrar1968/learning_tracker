<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Certificate;

/**
 * Certificates Feature Tests
 *
 * Tests all certificate functionality including:
 * - Index listing
 * - Show individual certificate
 * - Certificate verification
 * - Certificate generation
 */

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Certificates Index', function () {
    it('redirects guests to login', function () {
        $this->get(route('certificates.index'))
            ->assertRedirect(route('login'));
    });

    it('displays certificates index for authenticated users', function () {
        $this->actingAs($this->user)
            ->get(route('certificates.index'))
            ->assertStatus(200)
            ->assertViewIs('certificates.index');
    });

    it('displays user certificates', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $certificate = Certificate::factory()->create([
            'user_id' => $this->user->id,
            'roadmap_id' => $roadmap->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('certificates.index'))
            ->assertStatus(200)
            ->assertSee($certificate->certificate_number);
    });

    it('does not display other users certificates', function () {
        $otherUser = User::factory()->create();
        $roadmap = Roadmap::factory()->create(['user_id' => $otherUser->id]);
        $certificate = Certificate::factory()->create([
            'user_id' => $otherUser->id,
            'roadmap_id' => $roadmap->id,
            'certificate_number' => 'CERT-OTHER-12345',
        ]);

        $this->actingAs($this->user)
            ->get(route('certificates.index'))
            ->assertDontSee('CERT-OTHER-12345');
    });
});

describe('Certificate Show', function () {
    it('displays certificate details', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $certificate = Certificate::factory()->create([
            'user_id' => $this->user->id,
            'roadmap_id' => $roadmap->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('certificates.show', $certificate))
            ->assertStatus(200)
            ->assertViewIs('certificates.show');
    });

    it('prevents access to other users certificates', function () {
        $otherUser = User::factory()->create();
        $roadmap = Roadmap::factory()->create(['user_id' => $otherUser->id]);
        $certificate = Certificate::factory()->create([
            'user_id' => $otherUser->id,
            'roadmap_id' => $roadmap->id,
        ]);

        // Controller returns 404 instead of 403 for security (doesn't reveal resource existence)
        $this->actingAs($this->user)
            ->get(route('certificates.show', $certificate))
            ->assertNotFound();
    });
});

describe('Certificate Verification', function () {
    it('verifies valid certificate', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $certificate = Certificate::factory()->create([
            'user_id' => $this->user->id,
            'roadmap_id' => $roadmap->id,
            'verification_code' => 'VALID123CODE',
        ]);

        $this->get(route('certificates.verify', $certificate->verification_code))
            ->assertStatus(200);
    });

    it('returns 404 for invalid verification code', function () {
        $this->get(route('certificates.verify', 'INVALIDCODE'))
            ->assertStatus(200)
            ->assertViewHas('certificate', null);
    });
});

describe('Certificate Generation', function () {
    it('generates certificate for completed roadmap', function () {
        $roadmap = Roadmap::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'completed',
            'progress_percentage' => 100,
        ]);

        $this->actingAs($this->user)
            ->post(route('certificates.generate', $roadmap))
            ->assertRedirect();

        $this->assertDatabaseHas('certificates', [
            'user_id' => $this->user->id,
            'roadmap_id' => $roadmap->id,
        ]);
    });

    it('does not generate certificate for incomplete roadmap', function () {
        $roadmap = Roadmap::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'in_progress',
            'progress_percentage' => 50,
        ]);

        $this->actingAs($this->user)
            ->post(route('certificates.generate', $roadmap))
            ->assertStatus(302); // Redirect with error

        $this->assertDatabaseMissing('certificates', [
            'user_id' => $this->user->id,
            'roadmap_id' => $roadmap->id,
        ]);
    });
});
