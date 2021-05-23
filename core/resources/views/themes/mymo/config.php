<?php

return [
    [
        'code' => 'header',
        'name' => trans('app.header'),
        'cards' => [
            [
                'code' => 'site_header',
                'name' => trans('app.header'),
                'input_items' => [
                    [
                        'element' => 'site_header',
                        'title' => trans('app.header'),
                        'name' => 'site_header',
                    ],
                ]
            ],
            [
                'code' => 'main_menu',
                'name' => trans('app.main_menu'),
                'input_items' => [
                    [
                        'element' => 'menu',
                        'title' => trans('app.main_menu'),
                        'name' => 'menu',
                    ],
                ]
            ]
        ]
    ],
    [
        'code' => 'home_page',
        'name' => trans('app.home_page'),
        'cards' => [
            [
                'code' => 'slider',
                'name' => trans('app.slider'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'slider',
                        'title' => trans('app.slider'),
                        'name' => 'slider'
                    ]
                ]
            ],
            [
                'code' => 'slider_movies',
                'name' => trans('app.slider') . ' ' . trans('app.movies'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('app.title'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ]
                ]
            ],
            [
                'code' => 'genre1',
                'status' => true,
                'name' => trans('app.movie_list') . ' 1',
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('app.movie_list'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ],
                    [
                        'element' => 'select_genres',
                        'title' => trans('app.other_genres'),
                        'name' => 'child_genres',
                    ]
                ]
            ],
            [
                'code' => 'genre2',
                'status' => true,
                'name' => trans('app.movie_list') . ' 2',
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('app.movie_list'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ],
                    [
                        'element' => 'select_genres',
                        'title' => trans('app.other_genres'),
                        'name' => 'child_genres',
                    ]
                ]
            ],
            [
                'code' => 'genre3',
                'status' => true,
                'name' => trans('app.movie_list') . ' 3',
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('app.movie_list'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ],
                    [
                        'element' => 'select_genres',
                        'title' => trans('app.other_genres'),
                        'name' => 'child_genres',
                    ]
                ]
            ]
        ]
    ],
    [
        'code' => 'sidebar',
        'name' => trans('app.sidebar'),
        'cards' => [
            [
                'code' => 'widget1',
                'name' => trans('app.widget') . ' 1',
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'textarea',
                        'title' => trans('app.content'),
                        'name' => 'body',
                    ]
                ]
            ],
            [
                'code' => 'popular_movies',
                'name' => trans('app.popular_movies'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('app.title'),
                        'name' => 'title',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('app.maximum_movies'),
                        'name' => 'showpost',
                    ]
                ]
            ],
            [
                'code' => 'widget2',
                'name' => trans('app.widget') . ' 2',
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'textarea',
                        'title' => trans('app.content'),
                        'name' => 'body',
                    ]
                ]
            ],
            [
                'code' => 'widget3',
                'name' => trans('app.widget') . ' 3',
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'textarea',
                        'title' => trans('app.content'),
                        'name' => 'body',
                    ]
                ]
            ],
        ]
    ],
    [
        'code' => 'footer',
        'name' => trans('app.footer'),
        'cards' => [
            [
                'code' => 'column1',
                'name' => trans('app.column') . ' 1',
                'input_items' => [
                    [
                        'element' => 'media',
                        'title' => trans('app.logo'),
                        'name' => 'logo',
                    ],
                    [
                        'element' => 'textarea',
                        'title' => trans('app.description'),
                        'name' => 'description',
                    ]
                ]
            ],
            [
                'code' => 'column2',
                'name' => trans('app.column') . ' 2',
                'input_items' => [
                    [
                        'element' => 'footer_column',
                        'name' => 'column',
                    ]
                ]
            ],
            [
                'code' => 'column3',
                'name' => trans('app.column') . ' 3',
                'input_items' => [
                    [
                        'element' => 'footer_column',
                        'name' => 'column',
                    ]
                ]
            ]
        ]
    ],
];