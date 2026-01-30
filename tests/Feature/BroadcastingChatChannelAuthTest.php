<?php

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastingFactory;
use Illuminate\Contracts\Broadcasting\Broadcaster as BroadcastingBroadcaster;

it('authorizes subscribing to private-chat.{id} for the matching user', function () {
    Config::set('broadcasting.default', 'pusher');
    Config::set('broadcasting.connections.pusher.key', 'test-key');
    Config::set('broadcasting.connections.pusher.secret', 'test-secret');
    Config::set('broadcasting.connections.pusher.app_id', 'test-app-id');
    Config::set('broadcasting.connections.pusher.options.cluster', 'ap2');
    app()->forgetInstance('broadcast.manager');
    app()->forgetInstance(Illuminate\Broadcasting\BroadcastManager::class);
    app()->forgetInstance(BroadcastingFactory::class);
    app()->forgetInstance(BroadcastingBroadcaster::class);

    $user = User::factory()->create();

    $csrfToken = Str::random(40);

    $response = $this
        ->actingAs($user)
        ->withSession(['_token' => $csrfToken])
        ->withHeader('X-CSRF-TOKEN', $csrfToken)
        ->withHeader('X-Requested-With', 'XMLHttpRequest')
        ->postJson('/broadcasting/auth', [
            'channel_name' => 'private-chat.'.$user->id,
            'socket_id' => '1234.5678',
        ]);

    $response->dump();
    $response->assertSuccessful();
    expect($response->json())->toHaveKey('auth');
});

it('forbids subscribing to private-chat.{id} for a different user', function () {
    Config::set('broadcasting.default', 'pusher');
    Config::set('broadcasting.connections.pusher.key', 'test-key');
    Config::set('broadcasting.connections.pusher.secret', 'test-secret');
    Config::set('broadcasting.connections.pusher.app_id', 'test-app-id');
    Config::set('broadcasting.connections.pusher.options.cluster', 'ap2');
    app()->forgetInstance('broadcast.manager');
    app()->forgetInstance(Illuminate\Broadcasting\BroadcastManager::class);
    app()->forgetInstance(BroadcastingFactory::class);
    app()->forgetInstance(BroadcastingBroadcaster::class);

    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $csrfToken = Str::random(40);

    $response = $this
        ->actingAs($user)
        ->withSession(['_token' => $csrfToken])
        ->withHeader('X-CSRF-TOKEN', $csrfToken)
        ->withHeader('X-Requested-With', 'XMLHttpRequest')
        ->postJson('/broadcasting/auth', [
            'channel_name' => 'private-chat.'.$otherUser->id,
            'socket_id' => '1234.5678',
        ]);

    $response->assertForbidden();
});

