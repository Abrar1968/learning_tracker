<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\Certificate;

/**
 * Roadmaps Feature Tests
 *
 * Tests all roadmap functionality including:
 * - CRUD operations
 * - Topics management
 * - Progress tracking
 * - Forking and templates
 */

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Roadmap Index', function () {
    it('redirects guests to login', function () {
        $this->get(route('roadmaps.index'))
            ->assertRedirect(route('login'));
    });

    it('displays roadmaps index for authenticated users', function () {
        $this->actingAs($this->user)
            ->get(route('roadmaps.index'))
            ->assertStatus(200)
            ->assertViewIs('roadmaps.index');
    });

    it('displays user roadmaps', function () {
        $roadmap = Roadmap::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'My Learning Roadmap',
        ]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.index'))
            ->assertSee('My Learning Roadmap');
    });

    it('does not display other users roadmaps', function () {
        $otherUser = User::factory()->create();
        Roadmap::factory()->create([
            'user_id' => $otherUser->id,
            'title' => 'Other User Roadmap',
        ]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.index'))
            ->assertDontSee('Other User Roadmap');
    });
});

describe('Roadmap Create', function () {
    it('displays create form', function () {
        $this->actingAs($this->user)
            ->get(route('roadmaps.create'))
            ->assertStatus(200)
            ->assertViewIs('roadmaps.create');
    });

    it('creates a new roadmap', function () {
        $this->actingAs($this->user)
            ->post(route('roadmaps.store'), [
                'title' => 'New Test Roadmap',
                'description' => 'A test roadmap description',
                'target_end_date' => now()->addMonths(3)->format('Y-m-d'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('roadmaps', [
            'user_id' => $this->user->id,
            'title' => 'New Test Roadmap',
        ]);
    });

    it('validates required fields', function () {
        $this->actingAs($this->user)
            ->post(route('roadmaps.store'), [])
            ->assertSessionHasErrors(['title']);
    });
});

describe('Roadmap Show', function () {
    it('displays roadmap details', function () {
        $roadmap = Roadmap::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'Test Roadmap',
        ]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.show', $roadmap))
            ->assertStatus(200)
            ->assertSee('Test Roadmap');
    });

    it('displays roadmap topics', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        Topic::factory()->create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Topic One',
        ]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.show', $roadmap))
            ->assertSee('Topic One');
    });

    it('prevents access to other users roadmaps', function () {
        $otherUser = User::factory()->create();
        $roadmap = Roadmap::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.show', $roadmap))
            ->assertForbidden();
    });
});

describe('Roadmap Edit', function () {
    it('displays edit form', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.edit', $roadmap))
            ->assertStatus(200)
            ->assertViewIs('roadmaps.edit');
    });

    it('updates roadmap', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->put(route('roadmaps.update', $roadmap), [
                'title' => 'Updated Roadmap Title',
                'description' => 'Updated description',
                'target_end_date' => now()->addMonths(6)->format('Y-m-d'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('roadmaps', [
            'id' => $roadmap->id,
            'title' => 'Updated Roadmap Title',
        ]);
    });
});

describe('Roadmap Delete', function () {
    it('deletes roadmap', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->delete(route('roadmaps.destroy', $roadmap))
            ->assertRedirect();

        $this->assertSoftDeleted('roadmaps', ['id' => $roadmap->id]);
    });

    it('prevents deleting other users roadmaps', function () {
        $otherUser = User::factory()->create();
        $roadmap = Roadmap::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($this->user)
            ->delete(route('roadmaps.destroy', $roadmap))
            ->assertForbidden();
    });
});

describe('Roadmap Fork', function () {
    it('forks a roadmap', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        Topic::factory()->count(3)->create(['roadmap_id' => $roadmap->id]);

        $this->actingAs($this->user)
            ->post(route('roadmaps.fork', $roadmap))
            ->assertRedirect();

        $this->assertDatabaseCount('roadmaps', 2);
    });
});

describe('Roadmap Certificate', function () {
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
});
