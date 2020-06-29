<?php

Breadcrumbs::for('admin', function ($trail) {
    $trail->push(trans('app.home'), route('admin.dashboard'));
});

Breadcrumbs::for('genres-manager', function ($trail, $genre = null) {
    $trail->parent('admin');
    $trail->push(trans('app.genres'), route('admin.genres'));
    if ($genre) {
        if ($genre->name) {
            $trail->push($genre->name);
        }
        else {
            $trail->push(trans('app.add_new'));
        }
    }
});