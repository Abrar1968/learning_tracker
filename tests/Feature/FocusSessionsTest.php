<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\FocusSession;

/**
 * Focus Sessions Feature Tests
 *
 * Tests all focus timer functionality including:
 * - Index page access
 * - Starting/ending sessions
 * - Session history
 * - Heatmap data
 */

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Focus Index', function () {
    it('redirects guests to login', function () {
        $this->get(route('focus.index'))
            ->assertRedirect(route('login'));
    });

    it('displays focus timer for authenticated users', function () {
        $this->actingAs($this->user)
            ->get(route('focus.index'))
            ->assertStatus(200)
            ->assertViewIs('focus.index');
    });

    it('contains sidebar navigation', function () {
        $this->actingAs($this->user)
            ->get(route('focus.index'))
            ->assertSee('Focus Timer');
    });
});

describe('Focus Session Start', function () {
    it('starts a focus session', function () {
        $this->actingAs($this->user)
            ->post(route('focus.start'), [
                'duration' => 25,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('focus_sessions', [
            'user_id' => $this->user->id,
            'planned_duration' => 25,
        ]);

        // Verify session is active (ended_at is null)
        $session = FocusSession::where('user_id', $this->user->id)->latest()->first();
        expect($session->ended_at)->toBeNull();
    });

    it('starts a focus session with topic', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);

        $this->actingAs($this->user)
            ->post(route('focus.start'), [
                'duration' => 25,
                'topic_id' => $topic->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('focus_sessions', [
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
        ]);
    });
});

describe('Focus Session End', function () {
    it('ends a focus session', function () {
        $session = FocusSession::factory()->active()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->post(route('focus.end', $session))
            ->assertRedirect();

        $session->refresh();
        expect($session->ended_at)->not->toBeNull();
        expect($session->duration_minutes)->toBeGreaterThan(0);
    });
});

describe('Focus Status', function () {
    it('returns active session status', function () {
        FocusSession::factory()->active()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('focus.status'))
            ->assertStatus(200)
            ->assertJsonStructure(['active', 'session']);
    });

    it('returns no active session', function () {
        $this->actingAs($this->user)
            ->get(route('focus.status'))
            ->assertStatus(200)
            ->assertJson(['active' => false]);
    });
});

describe('Focus History', function () {
    it('displays focus history', function () {
        FocusSession::factory()->count(5)->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('focus.history'))
            ->assertStatus(200)
            ->assertViewIs('focus.history');
    });
});

describe('Focus Heatmap', function () {
    it('returns heatmap data', function () {
        FocusSession::factory()->count(3)->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('focus.heatmap'))
            ->assertStatus(200)
            ->assertJsonStructure([]);
    });
});
