<?php

use Illuminate\Support\Facades\Broadcast;

// routes/channels.php
Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId;
});

