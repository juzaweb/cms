<?php

namespace Juzaweb\Movie;

use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Movie\Http\Controllers\AjaxController;
use Juzaweb\Movie\Http\Controllers\Backend\TmdbController;

class MovieAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'registerMovie']
        );
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'registerTaxonomies']
        );
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'addSettingForm']
        );
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'registerResources']
        );
        $this->addAction(
            Action::FRONTEND_CALL_ACTION,
            [$this, 'addAjaxTheme']
        );
        $this->addAction(
            'post_type.movies.btn_group',
            [$this, 'addImportButton']
        );
        $this->addAction(
            'post_type.movies.index',
            [$this, 'addModalImport']
        );
        $this->addAction(
            Action::INIT_ACTION,
            [$this, 'addAjaxAdmin']
        );
    }

    public function registerMovie()
    {
        HookAction::registerPostType('movies', [
            'label' => trans('mymo::app.movies'),
            'menu_position' => 11,
            'menu_icon' => 'fa fa-film',
            'supports' => ['tag'],
            'metas' => [
                'origin_title' => [
                    'label' => trans('mymo::app.other_name')
                ],
                'tv_series' => [
                    'label' => trans('mymo::app.type'),
                    'type' => 'select',
                    'sidebar' => true,
                    'data' => [
                        'options' => [
                            '0' => trans('mymo::app.movie'),
                            '1' => trans('mymo::app.tv_series'),
                        ]
                    ],
                ],
                'poster' => [
                    'label' => trans('mymo::app.poster'),
                    'type' => 'image',
                    'sidebar' => true,
                ],
                'rating' => [
                    'label' => trans('mymo::app.rating')
                ],
                'release' => [
                    'label' => trans('mymo::app.release'),
                    'data' => [
                        'class' => 'datepicker',
                    ]
                ],
                'year' => [
                    'label' => trans('mymo::app.year')
                ],
                'runtime' => [
                    'label' => trans('mymo::app.runtime')
                ],
                'video_quality' => [
                    'label' => trans('mymo::app.video_quality')
                ],
                'trailer_link' => [
                    'label' => trans('mymo::app.trailer')
                ],
                'current_episode' => [
                    'label' => trans('mymo::app.current_episode')
                ],
                'max_episode' => [
                    'label' => trans('mymo::app.max_episode')
                ]
            ],
        ]);
    }

    public function registerTaxonomies()
    {
        HookAction::registerTaxonomy('genres', 'movies', [
            'label' => trans('mymo::app.genres'),
            'menu_position' => 6,
            'supports' => [
                'thumbnail'
            ],
        ]);

        HookAction::registerTaxonomy('countries', 'movies', [
            'label' => trans('mymo::app.countries'),
            'menu_position' => 7,
            'supports' => [
                'thumbnail'
            ],
        ]);

        HookAction::registerTaxonomy('actors', 'movies', [
            'label' => trans('mymo::app.actors'),
            'menu_box' => false,
            'menu_position' => 7,
            'supports' => [
                'thumbnail'
            ],
        ]);

        HookAction::registerTaxonomy('directors', 'movies', [
            'label' => trans('mymo::app.directors'),
            'menu_position' => 7,
            'menu_box' => false,
            'supports' => [
                'thumbnail'
            ],
        ]);

        HookAction::registerTaxonomy('writers', 'movies', [
            'label' => trans('mymo::app.writers'),
            'menu_position' => 7,
            'menu_box' => false,
            'supports' => [
                'thumbnail'
            ],
        ]);

        HookAction::registerTaxonomy('years', 'movies', [
            'label' => trans('mymo::app.years'),
            'menu_position' => 8,
            'show_in_menu' => false,
            'supports' => [],
        ]);
    }

    public function addSettingForm()
    {
        HookAction::registerConfig(
            [
                "tmdb_api_key",
                "player_watermark",
                "player_watermark_logo",
            ]
        );

        HookAction::addSettingForm(
            'mymo',
            [
                'name' => trans('mymo::app.mymo_setting'),
                'view' => view('mymo::setting.tmdb'),
                'priority' => 20
            ]
        );
    }

    public function addAdminMenus()
    {
        HookAction::addAdminMenu(
            trans('mymo::app.banner_ads'),
            'banner-ads',
            [
                'icon' => 'fa fa-file',
                'position' => 30,
                'parent' => 'setting',
            ]
        );

        HookAction::addAdminMenu(
            trans('mymo::app.video_ads'),
            'video-ads',
            [
                'icon' => 'fa fa-video-camera',
                'position' => 31,
                'parent' => 'setting',
            ]
        );
    }

    public function addAjaxTheme()
    {
        HookAction::registerFrontendAjax('movie-download', [
            'callback' => [app(AjaxController::class), 'download']
        ]);

        HookAction::registerFrontendAjax('get-player', [
            'callback' => [app(AjaxController::class), 'getPlayer']
        ]);

        HookAction::registerFrontendAjax('popular-movies', [
            'callback' => [app(AjaxController::class), 'getPopularMovies']
        ]);

        HookAction::registerFrontendAjax('movies-genre', [
            'callback' => [app(AjaxController::class), 'getMoviesByGenre']
        ]);

        HookAction::registerFrontendAjax('mymo_filter_form', [
            'callback' => [app(AjaxController::class), 'getFilterForm'],
        ]);
    }

    public function registerResources()
    {
        HookAction::registerResource('servers', 'movies', [
            'label' => trans('mymo::app.servers'),
            'label_action' => trans('mymo::app.upload'),
            'menu' => [
                'icon' => 'fa fa-server',
            ],
        ]);

        HookAction::registerResource('download', 'movies', [
            'label' => trans('mymo::app.download'),
            'label_action' => trans('mymo::app.download'),
            'menu' => [
                'icon' => 'fa fa-download',
            ],
            'metas' => [
                'url' => [
                    'label' => trans('mymo::app.url'),
                ],
            ]
        ]);

        HookAction::registerResource('files', null, [
            'label' => trans('mymo::app.upload_videos'),
            'label_action' => trans('mymo::app.upload_videos'),
            'parent' => 'servers',
            'metas' => [
                'source' => [
                    'label' => trans('mymo::app.source'),
                    'type' => 'select',
                    'data' => [
                        'options' => [
                            'mp4' => 'MP4 From URL',
                            'youtube' => 'Youtube',
                            'vimeo' => 'Vimeo',
                            'gdrive' => 'Google Drive',
                            'mkv' => 'MKV From URL',
                            'webm' => 'WEBM From URL',
                            'm3u8' => 'M3U8 From URL',
                            'embed' => 'Embed URL',
                        ]
                    ]
                ],
                'url' => [
                    'label' => trans('mymo::app.url'),
                ],
            ],
        ]);
    }

    public function addImportButton()
    {
        echo '<a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#tmdb-modal">
        <i class="fa fa-download"></i> '. trans('mymo::app.add_from_tmdb') .'
        </a>';
    }

    public function addModalImport()
    {
        echo view('mymo::tmdb_import')
            ->render();
    }

    public function addAjaxAdmin()
    {
        HookAction::registerAdminAjax('tmdb-add_movie', [
            'callback' => [TmdbController::class, 'addMovie'],
            'method' => 'post'
        ]);
    }
}
