<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('user.top'));
});

// Home > level1 > level2 > ...
Breadcrumbs::for('under_layer', function ($trail, $under_layers = []) {
    $trail->parent('home');

    foreach ($under_layers as $layer) {
        $trail->push($layer['title'], $layer['route'] ? $layer['route'] : null);
    }
});