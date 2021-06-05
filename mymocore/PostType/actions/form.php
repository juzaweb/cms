<?php

add_action('post_type.posts.form.rigth', function ($model) {
    echo view('mymo_core::components.taxonomies', [
        'postType' => 'posts',
        'model' => $model
    ])->render();
});
