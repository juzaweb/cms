<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

return [
    'enable' => env('JW_FRONTEND_ENABLE', true),

    'route_prefix' => null,

    'stubs' => [
        'files' => [
            'index' => 'views/index.twig',
            'header' => 'views/header.twig',
            'footer' => 'views/footer.twig',
            'search' => 'views/search.twig',
            'single' => 'views/template-parts/single.twig',
            'page' => 'views/template-parts/single-page.twig',
            'taxonomy' => 'views/template-parts/taxonomy.twig',
            'profile' => 'views/profile/index.twig',
            'content' => 'views/template-parts/content.twig',
            'home' => 'views/templates/home.twig',
            'register_json' => 'register.json',
        ],
        'folders' => [
            'views' => 'views',
            'views/auth' => 'views/auth',
            'views/profile' => 'views/profile',
            'views/template-parts' => 'views/template-parts',
            'views/templates' => 'views/templates'
        ],
    ],
];
