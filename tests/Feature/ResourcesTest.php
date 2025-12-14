<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\Resource;

/**
 * Resources Feature Tests
 *
 * Tests all resource functionality including:
 * - CRUD operations
 * - Completion tracking
 * - File attachments
 */

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
    $this->topic = Topic::factory()->create(['roadmap_id' => $this->roadmap->id]);
});

describe('Resource Create', function () {
    it('displays create form', function () {
        $this->actingAs($this->user)
            ->get(route('topics.resources.create', $this->topic))
            ->assertStatus(200)
            ->assertViewIs('resources.create');
    });

    it('creates a new resource', function () {
        $this->actingAs($this->user)
            ->post(route('topics.resources.store', $this->topic), [
                'title' => 'New Resource',
                'description' => 'Resource description',
                'type' => 'article',
                'url' => 'https://example.com/article',
                'estimated_duration' => 30,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('resources', [
            'topic_id' => $this->topic->id,
            'title' => 'New Resource',
            'type' => 'article',
        ]);
    });

    it('validates required fields', function () {
        $this->actingAs($this->user)
            ->post(route('topics.resources.store', $this->topic), [])
            ->assertSessionHasErrors(['title', 'type']);
    });

    it('validates url format when provided', function () {
        $this->actingAs($this->user)
            ->post(route('topics.resources.store', $this->topic), [
                'title' => 'Video Resource',
                'type' => 'video',
                'url' => 'invalid-url-format',
            ])
            ->assertSessionHasErrors(['url']);
    });
});

describe('Resource Edit', function () {
    it('displays edit form', function () {
        $resource = Resource::factory()->create([
            'topic_id' => $this->topic->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('topics.resources.edit', [$this->topic, $resource]))
            ->assertStatus(200)
            ->assertViewIs('resources.edit');
    });

    it('updates resource', function () {
        $resource = Resource::factory()->create([
            'topic_id' => $this->topic->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->put(route('topics.resources.update', [$this->topic, $resource]), [
                'title' => 'Updated Resource Title',
                'description' => 'Updated description',
                'type' => 'article',
                'url' => 'https://example.com/updated',
                'estimated_duration' => 45,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('resources', [
            'id' => $resource->id,
            'title' => 'Updated Resource Title',
        ]);
    });
});

describe('Resource Delete', function () {
    it('deletes resource', function () {
        $resource = Resource::factory()->create([
            'topic_id' => $this->topic->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->delete(route('topics.resources.destroy', [$this->topic, $resource]))
            ->assertRedirect();

        $this->assertSoftDeleted('resources', ['id' => $resource->id]);
    });
});

describe('Resource Completion', function () {
    it('marks resource as complete', function () {
        $resource = Resource::factory()->create([
            'topic_id' => $this->topic->id,
            'user_id' => $this->user->id,
            'is_completed' => false,
        ]);

        $this->actingAs($this->user)
            ->patch(route('resources.complete', $resource))
            ->assertRedirect();

        $this->assertDatabaseHas('resources', [
            'id' => $resource->id,
            'is_completed' => true,
        ]);
    });
});
