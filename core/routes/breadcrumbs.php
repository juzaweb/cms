<?php

Breadcrumbs::for('admin', function ($trail) {
    $trail->push(trans('app.home'), route('admin.dashboard'));
});

Breadcrumbs::for('manager', function ($trail, $parent, $model = null) {
    $trail->parent('admin');
    $trail->push($parent['name'], $parent['url']);
    
    if ($model) {
        if (isset($model->name) || isset($model->title)) {
            if (isset($model->name)) {
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

Breadcrumbs::for('multiple_parent', function ($trail, $parents, $model = null) {
    $trail->parent('admin');
    foreach ($parents as $parent) {
        $trail->push($parent['name'], $parent['url']);
    }
    
    if ($model) {
        if ($model->name || $model->title || $model->label) {
            if ($model->name) {
                $trail->push($model->name);
            }
            else if ($model->title) {
                $trail->push($model->title);
            }
            else {
                $trail->push($model->label);
            }
        }
        else {
            $trail->push(trans('app.add_new'));
        }
    }
});