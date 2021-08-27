<?php

return [
    [
        'code' => 'header',
        'name' => trans('theme::app.header'),
        'cards' => [
            [
                'code' => 'site_header',
                'name' => trans('theme::app.header'),
                'input_items' => [
                    [
                        'element' => 'site_header',
                        'title' => trans('theme::app.header'),
                        'name' => 'site_header',
                    ],
                ]
            ],
            [
                'code' => 'main_menu',
                'name' => trans('theme::app.main_menu'),
                'input_items' => [
                    [
                        'element' => 'menu',
                        'title' => trans('theme::app.main_menu'),
                        'name' => 'menu',
                    ],
                ]
            ]
        ]
    ],
    [
        'code' => 'home_page',
        'name' => trans('theme::app.home_page'),
        'cards' => [
            [
                'code' => 'slider',
                'name' => trans('theme::app.slider'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'slider',
                        'title' => trans('theme::app.slider'),
                        'name' => 'slider'
                    ]
                ]
            ],
            [
                'code' => 'slider_movies',
                'name' => trans('theme::app.slider') . ' ' . trans('theme::app.movies'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('theme::app.title'),
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
                'name' => trans('theme::app.movie_list') . ' 1',
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('theme::app.movie_list'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ],
                    [
                        'element' => 'select_genres',
                        'title' => trans('theme::app.other_genres'),
                        'name' => 'child_genres',
                    ]
                ]
            ],
            [
                'code' => 'genre2',
                'status' => true,
                'name' => trans('theme::app.movie_list') . ' 2',
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('theme::app.movie_list'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ],
                    [
                        'element' => 'select_genres',
                        'title' => trans('theme::app.other_genres'),
                        'name' => 'child_genres',
                    ]
                ]
            ],
            [
                'code' => 'genre3',
                'status' => true,
                'name' => trans('theme::app.movie_list') . ' 3',
                'input_items' => [
                    [
                        'element' => 'genre',
                        'title' => trans('theme::app.movie_list'),
                        'name' => 'genre',
                        'limit' => [
                            'default' => 12
                        ]
                    ],
                    [
                        'element' => 'select_genres',
                        'title' => trans('theme::app.other_genres'),
                        'name' => 'child_genres',
                    ]
                ]
            ]
        ]
    ],
    [
        'code' => 'sidebar',
        'name' => trans('theme::app.sidebar'),
        'cards' => [
            [
                'code' => 'widget1',
                'name' => trans('theme::app.widget') . ' 1',
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'textarea',
                        'title' => trans('theme::app.content'),
                        'name' => 'body',
                    ]
                ]
            ],
            [
                'code' => 'popular_movies',
                'name' => trans('theme::app.popular_movies'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('theme::app.title'),
                        'name' => 'title',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('theme::app.maximum_movies'),
                        'name' => 'showpost',
                    ]
                ]
            ],
            [
                'code' => 'widget2',
                'name' => trans('theme::app.widget') . ' 2',
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'textarea',
                        'title' => trans('theme::app.content'),
                        'name' => 'body',
                    ]
                ]
            ],
            [
                'code' => 'widget3',
                'name' => trans('theme::app.widget') . ' 3',
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'textarea',
                        'title' => trans('theme::app.content'),
                        'name' => 'body',
                    ]
                ]
            ],
        ]
    ],
    [
        'code' => 'footer',
        'name' => trans('theme::app.footer'),
        'cards' => [
            [
                'code' => 'column1',
                'name' => trans('theme::app.column') . ' 1',
                'input_items' => [
                    [
                        'element' => 'media',
                        'title' => trans('theme::app.logo'),
                        'name' => 'logo',
                    ],
                    [
                        'element' => 'textarea',
                        'title' => trans('theme::app.description'),
                        'name' => 'description',
                    ]
                ]
            ],
            [
                'code' => 'column2',
                'name' => trans('theme::app.column') . ' 2',
                'input_items' => [
                    [
                        'element' => 'footer_column',
                        'name' => 'column',
                    ]
                ]
            ],
            [
                'code' => 'column3',
                'name' => trans('theme::app.column') . ' 3',
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