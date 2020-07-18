<?php

return [
    [
        'code' => 'header',
        'name' => trans('main.header'),
        'cards' => [
            [
                'code' => 'site_header',
                'name' => trans('main.header'),
                'input_items' => [
                    [
                        'element' => 'site_header',
                        'title' => trans('main.header'),
                        'name' => 'site_header',
                    ],
                ]
            ],
            [
                'code' => 'main_menu',
                'name' => trans('main.main_menu'),
                'input_items' => [
                    [
                        'element' => 'menu',
                        'title' => trans('main.main_menu'),
                        'name' => 'menu',
                    ],
                ]
            ]
        ]
    ],
    [
        'code' => 'home_page',
        'name' => trans('main.home_page'),
        'cards' => [
            [
                'code' => 'slider',
                'name' => trans('main.slider'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'slider',
                        'title' => trans('main.slider'),
                        'name' => 'slider'
                    ]
                ]
            ],
            [
                'code' => 'banners',
                'status' => true,
                'name' => trans('main.banners_left'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title') . ' 1',
                        'name' => 'title1',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('main.url') . ' 1',
                        'name' => 'url1',
                    ],
                    [
                        'element' => 'media',
                        'title' => trans('main.banner') . ' 1',
                        'name' => 'banner1',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('main.title') . ' 2',
                        'name' => 'title2',
                    ],
                    [
                        'element' => 'media',
                        'title' => trans('main.banner') . ' 2',
                        'name' => 'banner2',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('main.url') . ' 2',
                        'name' => 'url2',
                    ]
                ]
            ],
            [
                'code' => 'slogan',
                'name' => trans('main.slogan'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'slogan_icon',
                        'title' => trans('main.slogan'),
                        'name' => 'slogan',
                    ],
                ]
            ],
            [
                'code' => 'product_list1',
                'status' => true,
                'name' => trans('main.product_list') . ' 1',
                'input_items' => [
                    [
                        'element' => 'category',
                        'title' => trans('main.new_products'),
                        'name' => 'category',
                    ]
                ]
            ],
            [
                'code' => 'product_list2',
                'status' => true,
                'name' => trans('main.product_list') . ' 2',
                'input_items' => [
                    [
                        'element' => 'category',
                        'title' => trans('main.product_list'),
                        'name' => 'category',
                    ]
                ]
            ],
            [
                'code' => 'product_list3',
                'status' => true,
                'name' => trans('main.product_list') . ' 3',
                'input_items' => [
                    [
                        'element' => 'category',
                        'title' => trans('main.product_list'),
                        'name' => 'category',
                    ]
                ]
            ],
            [
                'code' => 'product_list4',
                'status' => true,
                'name' => trans('main.product_list') . ' 4',
                'input_items' => [
                    [
                        'element' => 'category',
                        'title' => trans('main.product_list'),
                        'name' => 'category',
                    ]
                ]
            ],
            [
                'code' => 'recommend_products',
                'status' => true,
                'name' => trans('main.recommend_products'),
                'input_items' => [
                    [
                        'element' => 'category',
                        'title' => trans('main.recommend_products'),
                        'name' => 'category',
                    ],
                ]
            ],
            [
                'code' => 'feature_products',
                'status' => true,
                'name' => trans('main.feature_products'),
                'input_items' => [
                    [
                        'element' => 'category',
                        'title' => trans('main.feature_products'),
                        'name' => 'category',
                    ],
                ]
            ],
            [
                'code' => 'news',
                'status' => true,
                'name' => trans('main.news'),
                'input_items' => [
                    [
                        'element' => 'news',
                        'title' => trans('main.news'),
                        'name' => 'category',
                    ],
                ]
            ],
            [
                'code' => 'banner_bottom',
                'status' => true,
                'name' => trans('main.banner_bottom'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'name' => 'title',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('main.link'),
                        'name' => 'link',
                    ],
                    [
                        'element' => 'media',
                        'title' => trans('main.banner'),
                        'name' => 'banner',
                    ],
                ]
            ]
        ]
    ],
    [
        'code' => 'category_page',
        'name' => trans('main.category_page'),
        'cards' => [
            [
                'code' => 'menu_link',
                'status' => true,
                'name' => trans('main.link_list'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'type' => 'text',
                        'name' => 'title',
                    ],
                    [
                        'element' => 'menu',
                        'title' => trans('main.link_list'),
                        'name' => 'menu',
                    ]
                ]
            ],
            [
                'code' => 'banner',
                'status' => true,
                'name' => trans('main.banner'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'type' => 'text',
                        'name' => 'title',
                    ],
                    [
                        'element' => 'media',
                        'title' => trans('main.banner'),
                        'name' => 'banner',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('main.link'),
                        'type' => 'text',
                        'name' => 'link',
                    ]
                ]
            ]
        ]
    ],
    [
        'code' => 'post_page',
        'name' => trans('main.news_page'),
        'cards' => [
            [
                'code' => 'other_list',
                'status' => true,
                'name' => trans('main.other_posts'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'name' => 'title',
                    ]
                ]
            ],
            [
                'code' => 'tags',
                'status' => true,
                'name' => trans('main.tags'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'name' => 'title',
                    ]
                ]
            ],
            [
                'code' => 'tags',
                'status' => true,
                'name' => trans('main.tags'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'name' => 'title',
                    ]
                ]
            ],
            [
                'code' => 'banner',
                'status' => true,
                'name' => trans('main.banner'),
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'name' => 'title',
                    ],
                    [
                        'element' => 'media',
                        'title' => trans('main.banner'),
                        'name' => 'banner',
                    ],
                    [
                        'element' => 'input',
                        'title' => trans('main.url'),
                        'name' => 'url',
                    ]
                ]
            ]
        ]
    ],
    [
        'code' => 'footer',
        'name' => trans('main.footer'),
        'cards' => [
            [
                'code' => 'brands_slider',
                'name' => trans('main.brands_slider'),
                'status' => true,
                'input_items' => [
                    [
                        'element' => 'slider',
                        'title' => trans('main.brands'),
                        'name' => 'slider',
                    ]
                ]
            ],
            [
                'code' => 'social',
                'name' => trans('main.social'),
                'status' => true,
            ],
            [
                'code' => 'column1',
                'name' => trans('main.column') . ' 1',
                'input_items' => [
                    [
                        'element' => 'media',
                        'title' => trans('main.logo'),
                        'type' => 'text',
                        'name' => 'logo',
                    ],
                    [
                        'element' => 'textarea',
                        'title' => trans('main.description'),
                        'name' => 'description',
                    ],
                    [
                        'element' => 'slider',
                        'title' => trans('main.slider_payment_method'),
                        'name' => 'payment_methods',
                    ]
                ]
            ],
            [
                'code' => 'column2',
                'name' => trans('main.column') . ' 2',
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'type' => 'text',
                        'name' => 'title',
                    ],
                    [
                        'element' => 'menu',
                        'title' => trans('main.menu'),
                        'name' => 'menu',
                    ]
                ]
            ],
            [
                'code' => 'column3',
                'name' => trans('main.column') . ' 3',
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'type' => 'text',
                        'name' => 'title',
                    ],
                    [
                        'element' => 'menu',
                        'title' => trans('main.menu'),
                        'name' => 'menu',
                    ]
                ]
            ],
            [
                'code' => 'column4',
                'name' => trans('main.column') . ' 4',
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'type' => 'text',
                        'name' => 'title',
                    ],
                    [
                        'element' => 'menu',
                        'title' => trans('main.menu'),
                        'name' => 'menu',
                    ]
                ]
            ],
            [
                'code' => 'column5',
                'name' => trans('main.column') . ' 5',
                'input_items' => [
                    [
                        'element' => 'input',
                        'title' => trans('main.title'),
                        'type' => 'text',
                        'name' => 'title',
                    ]
                ]
            ]
        ]
    ],
];