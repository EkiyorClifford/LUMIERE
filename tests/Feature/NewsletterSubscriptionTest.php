<?php

use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('newsletter endpoint returns json for ajax submission', function () {
    /** @var TestCase $this */
    $response = $this->postJson(route('newsletter'), [
        'email' => 'client@example.com',
        'source' => 'collections',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Thank you for subscribing!',
        ]);

    $this->assertDatabaseHas('subscribers', [
        'email' => 'client@example.com',
        'source' => 'collections',
    ]);
});

test('newsletter endpoint returns already subscribed message for existing emails', function () {
    /** @var TestCase $this */
    Subscriber::query()->create([
        'email' => 'client@example.com',
        'source' => 'collections',
        'status' => 'active',
        'unsubscribe_token' => 'token-1234567890',
        'subscribed_at' => now(),
    ]);

    $response = $this->postJson(route('newsletter'), [
        'email' => 'client@example.com',
        'source' => 'collections',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'You are already subscribed.',
        ]);
});
