<?php

Breadcrumbs::for('admin', function ($trail) {
    $trail->push(trans('app.home'), route('admin.dashboard'));
});

Breadcrumbs::for('manager', function ($trail, $parent, $model = null) {
    $trail->parent('admin');
    $trail->push($parent['name'], $parent['url']);
    
    if ($model) {
        if ($model->name || $model->title) {
            if ($model->name) {
                $trail->push($model->name);
            }
            else {
                $trail->push($model->title);
            }
        }
        else {
            $trail->push(trans('app.add_new'));
        }
    }
});