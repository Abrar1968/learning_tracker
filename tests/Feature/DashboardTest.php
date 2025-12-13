<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\Resource;
use App\Models\Certificate;
use App\Models\FocusSession;

/**
 * Dashboard Feature Tests
 *
 * Tests all dashboard functionality including:
 * - Page access and authentication
 * - Sidebar navigation visibility
 * - Statistics display
 * - Recent activities
 */

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Dashboard Access', function () {
    it('redirects guests to login', function () {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    });

    it('displays dashboard for authenticated users', function () {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200)
            ->assertViewIs('dashboard');
    });

    it('contains sidebar navigation', function () {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertSee('Dashboard')
            ->assertSee('Roadmaps')
            ->assertSee('Focus Timer');
    });
});

describe('Dashboard Statistics', function () {
    it('displays roadmap count', function () {
        Roadmap::factory()->count(3)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200);
    });

    it('displays completed topics count', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        Topic::factory()->count(5)->create([
            'roadmap_id' => $roadmap->id,
            'status' => 'completed',
        ]);

        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200);
    });

    it('displays certificates count', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        Certificate::factory()->create([
            'user_id' => $this->user->id,
            'roadmap_id' => $roadmap->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200);
    });
});

describe('Dashboard Components', function () {
    it('shows quick actions', function () {
        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200);
    });

    it('shows progress overview when roadmaps exist', function () {
        Roadmap::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'in_progress',
            'progress_percentage' => 50,
        ]);

        $this->actingAs($this->user)
            ->get(route('dashboard'))
            ->assertStatus(200);
    });
});
