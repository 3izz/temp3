<?php

use Illuminate\Routing\Route;

it('registers the broadcasting auth route', function () {
    $uris = collect(app('router')->getRoutes())
        ->map(fn (Route $route): string => $route->uri())
        ->values()
        ->all();

    expect($uris)->toContain('broadcasting/auth');
});

