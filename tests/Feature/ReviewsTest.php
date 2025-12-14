<?php

use App\Models\User;
use App\Models\Roadmap;
use App\Models\Topic;
use App\Models\ReviewSchedule;

/**
 * Reviews Feature Tests
 *
 * Tests all spaced repetition review functionality including:
 * - Index page with pending reviews
 * - Adding topics/resources to review
 * - Recording review results
 * - Suspending and resuming reviews
 */

beforeEach(function () {
    $this->user = User::factory()->create();
});

describe('Reviews Index', function () {
    it('redirects guests to login', function () {
        $this->get(route('reviews.index'))
            ->assertRedirect(route('login'));
    });

    it('displays reviews index for authenticated users', function () {
        $this->actingAs($this->user)
            ->get(route('reviews.index'))
            ->assertStatus(200)
            ->assertViewIs('reviews.index');
    });

    it('contains sidebar navigation', function () {
        $this->actingAs($this->user)
            ->get(route('reviews.index'))
            ->assertSee('Reviews');
    });

    it('displays pending reviews', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create([
            'roadmap_id' => $roadmap->id,
            'title' => 'Review Topic',
        ]);

        ReviewSchedule::factory()->create([
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
            'next_review_date' => now(),
            'is_active' => true,
        ]);

        $this->actingAs($this->user)
            ->get(route('reviews.index'))
            ->assertStatus(200);
    });
});

describe('Add to Review', function () {
    it('adds topic to review schedule', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);

        $this->actingAs($this->user)
            ->post(route('reviews.addTopic', $topic))
            ->assertRedirect();

        $this->assertDatabaseHas('review_schedules', [
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
        ]);
    });
});

describe('Review Show', function () {
    it('displays review details', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);
        $review = ReviewSchedule::factory()->create([
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('reviews.show', $review))
            ->assertStatus(200)
            ->assertViewIs('reviews.show');
    });

    it('prevents access to other users reviews', function () {
        $otherUser = User::factory()->create();
        $roadmap = Roadmap::factory()->create(['user_id' => $otherUser->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);
        $review = ReviewSchedule::factory()->create([
            'user_id' => $otherUser->id,
            'topic_id' => $topic->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('reviews.show', $review))
            ->assertForbidden();
    });
});

describe('Record Review', function () {
    it('records review with quality rating', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);
        $review = ReviewSchedule::factory()->create([
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
            'repetition_count' => 0,
        ]);

        $this->actingAs($this->user)
            ->post(route('reviews.record', $review), [
                'quality' => 4,
            ])
            ->assertRedirect();

        $review->refresh();
        expect($review->repetition_count)->toBe(1);
        expect($review->last_review_date)->not->toBeNull();
    });
});

describe('Suspend Review', function () {
    it('suspends a review schedule', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);
        $review = ReviewSchedule::factory()->create([
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
            'is_active' => true,
        ]);

        $this->actingAs($this->user)
            ->post(route('reviews.suspend', $review))
            ->assertRedirect();

        $review->refresh();
        expect($review->is_active)->toBeFalse();
    });
});

describe('Resume Review', function () {
    it('resumes a suspended review', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);
        $review = ReviewSchedule::factory()->create([
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
            'is_active' => false,
        ]);

        $this->actingAs($this->user)
            ->post(route('reviews.resume', $review))
            ->assertRedirect();

        $review->refresh();
        expect($review->is_active)->toBeTrue();
    });
});

describe('Reset Review', function () {
    it('resets review schedule', function () {
        $roadmap = Roadmap::factory()->create(['user_id' => $this->user->id]);
        $topic = Topic::factory()->create(['roadmap_id' => $roadmap->id]);
        $review = ReviewSchedule::factory()->create([
            'user_id' => $this->user->id,
            'topic_id' => $topic->id,
            'repetition_count' => 5,
            'interval_days' => 30,
        ]);

        $this->actingAs($this->user)
            ->post(route('reviews.reset', $review))
            ->assertRedirect();

        $review->refresh();
        expect($review->repetition_count)->toBe(0);
        expect($review->interval_days)->toBe(1);
    });
});
