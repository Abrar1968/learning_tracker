<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\Resource;

/**
 * Topics Feature Tests
 *
 * Tests all topic functionality including:
 * - CRUD operations
 * - Progress tracking
 * - Subtopics
 * - Resources management
 */

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
});

describe('Topic Create', function () {
    it('displays create form', function () {
        $this->actingAs($this->user)
            ->get(route('roadmaps.topics.create', $this->roadmap))
            ->assertStatus(200)
            ->assertViewIs('topics.create');
    });

    it('creates a new topic', function () {
        $this->actingAs($this->user)
            ->post(route('roadmaps.topics.store', $this->roadmap), [
                'title' => 'New Topic',
                'description' => 'Topic description',
                'estimated_hours' => 10,
                'weightage' => 5,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('topics', [
            'roadmap_id' => $this->roadmap->id,
            'title' => 'New Topic',
        ]);
    });

    it('validates required fields', function () {
        $this->actingAs($this->user)
            ->post(route('roadmaps.topics.store', $this->roadmap), [])
            ->assertSessionHasErrors(['title']);
    });
});

describe('Topic Show', function () {
    it('displays topic details', function () {
        $topic = Topic::factory()->create([
            'roadmap_id' => $this->roadmap->id,
            'title' => 'Test Topic',
        ]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.topics.show', [$this->roadmap, $topic]))
            ->assertStatus(200)
            ->assertSee('Test Topic');
    });

    it('displays topic resources', function () {
        $topic = Topic::factory()->create(['roadmap_id' => $this->roadmap->id]);
        Resource::factory()->create([
            'topic_id' => $topic->id,
            'user_id' => $this->user->id,
            'title' => 'Resource One',
        ]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.topics.show', [$this->roadmap, $topic]))
            ->assertSee('Resource One');
    });
});

describe('Topic Edit', function () {
    it('displays edit form', function () {
        $topic = Topic::factory()->create(['roadmap_id' => $this->roadmap->id]);

        $this->actingAs($this->user)
            ->get(route('roadmaps.topics.edit', [$this->roadmap, $topic]))
            ->assertStatus(200)
            ->assertViewIs('topics.edit');
    });

    it('updates topic', function () {
        $topic = Topic::factory()->create(['roadmap_id' => $this->roadmap->id]);

        $this->actingAs($this->user)
            ->put(route('roadmaps.topics.update', [$this->roadmap, $topic]), [
                'title' => 'Updated Topic Title',
                'description' => 'Updated description',
                'estimated_hours' => 15,
                'weightage' => 8,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'title' => 'Updated Topic Title',
        ]);
    });
});

describe('Topic Delete', function () {
    it('deletes topic', function () {
        $topic = Topic::factory()->create(['roadmap_id' => $this->roadmap->id]);

        $this->actingAs($this->user)
            ->delete(route('roadmaps.topics.destroy', [$this->roadmap, $topic]))
            ->assertRedirect();

        $this->assertDatabaseMissing('topics', ['id' => $topic->id]);
    });
});

describe('Topic Progress', function () {
    it('starts topic progress', function () {
        $topic = Topic::factory()->create([
            'roadmap_id' => $this->roadmap->id,
            'status' => 'not_started',
        ]);

        $this->actingAs($this->user)
            ->post(route('progress.start', $topic))
            ->assertRedirect();

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'status' => 'in_progress',
        ]);
    });

    it('completes topic', function () {
        $topic = Topic::factory()->create([
            'roadmap_id' => $this->roadmap->id,
            'status' => 'in_progress',
        ]);

        $this->actingAs($this->user)
            ->post(route('progress.complete', $topic))
            ->assertRedirect();

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'status' => 'completed',
        ]);
    });

    it('logs time to topic', function () {
        $topic = Topic::factory()->create([
            'roadmap_id' => $this->roadmap->id,
            'actual_hours' => 0,
        ]);

        $this->actingAs($this->user)
            ->post(route('progress.logTime', $topic), [
                'hours' => 2,
            ])
            ->assertRedirect();

        $topic->refresh();
        expect($topic->actual_hours)->toBeGreaterThanOrEqual(2);
    });
});

describe('Topic Reorder', function () {
    it('reorders topics', function () {
        $topic1 = Topic::factory()->create(['roadmap_id' => $this->roadmap->id, 'order' => 1]);
        $topic2 = Topic::factory()->create(['roadmap_id' => $this->roadmap->id, 'order' => 2]);

        $this->actingAs($this->user)
            ->post(route('topics.reorder', $this->roadmap), [
                'topics' => [$topic2->id, $topic1->id],
            ])
            ->assertStatus(200);
    });
});
