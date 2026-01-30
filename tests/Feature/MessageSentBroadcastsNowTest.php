<?php

use App\Events\MessageSent;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

it('broadcasts message sent immediately (no queue worker required)', function () {
    expect(MessageSent::class)->toImplement(ShouldBroadcastNow::class);
});

