<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

return [
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
    ]
];
