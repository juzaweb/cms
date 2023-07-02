<?php

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Juzaweb\CMS\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Access Laravels auth class in your Twig templates.
 */
class Custom extends AbstractExtension
{
    public function getName(): string
    {
        return 'App_Extension_Laravel_Custom';
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('config', 'get_config'),
            new TwigFunction('theme_config', 'get_theme_config'),
            new TwigFunction('get_template_part', 'get_template_part'),
            new TwigFunction('text_field', 'Field::text'),
            new TwigFunction('textarea_field', 'Field::textarea'),
            new TwigFunction('select_field', 'Field::select'),
            new TwigFunction('select_taxonomy_field', 'Field::selectTaxonomy'),
            new TwigFunction('select_resource_field', 'Field::selectResource'),
            new TwigFunction('jw_nav_menu', 'jw_nav_menu', ['is_safe' => ['html']]),
            new TwigFunction('request_is', [app('request'), 'is']),
            new TwigFunction('json_decode', 'json_decode'),
            new TwigFunction('json_encode', 'json_encode'),
            new TwigFunction('theme_header', 'theme_header'),
            new TwigFunction('theme_after_body', 'theme_after_body'),
            new TwigFunction('theme_footer', 'theme_footer'),
            new TwigFunction('csrf_token', 'csrf_token'),
            new TwigFunction('csrf_field', 'csrf_field'),
            new TwigFunction('theme_action', 'theme_action'),
            new TwigFunction('comment_template', 'comment_template'),
            new TwigFunction('get_posts', 'get_posts'),
            new TwigFunction('get_logo', 'get_logo'),
            new TwigFunction('get_post_taxonomy', 'get_post_taxonomy'),
            new TwigFunction('get_post_taxonomies', 'get_post_taxonomies'),
            new TwigFunction('get_related_posts', 'get_related_posts'),
            new TwigFunction('dynamic_sidebar', 'dynamic_sidebar'),
            new TwigFunction('upload_url', 'upload_url'),
            new TwigFunction('paginate_links', 'paginate_links'),
            new TwigFunction('is_string', 'is_string'),
            new TwigFunction('is_array', 'is_array'),
            new TwigFunction('body_class', 'body_class'),
            new TwigFunction('get_post_resource', 'get_post_resource'),
            new TwigFunction('get_post_resources', 'get_post_resources'),
            new TwigFunction('comment_form', 'comment_form'),
            new TwigFunction('get_previous_post', 'get_previous_post'),
            new TwigFunction('json_encode', 'json_encode'),
            new TwigFunction('md5', 'md5'),
            new TwigFunction('is_home', 'is_home'),
            new TwigFunction('is_admin', 'is_admin'),
            new TwigFunction('has_permission', 'has_permission'),
            new TwigFunction('get_next_post', 'get_next_post'),
            new TwigFunction('get_taxonomy', 'get_taxonomy'),
            new TwigFunction('get_taxonomies', 'get_taxonomies'),
            new TwigFunction('get_star_rating_post', 'get_star_rating_post'),
            new TwigFunction('get_total_rating_post', 'get_total_rating_post'),
            new TwigFunction('get_popular_posts', 'get_popular_posts'),
            new TwigFunction('dynamic_block', 'dynamic_block'),
            new TwigFunction('get_locale', 'get_locale'),
            new TwigFunction('home_url', 'home_url'),
            new TwigFunction('sub_words', 'sub_words'),
            new TwigFunction('share_url', 'share_url'),
            new TwigFunction('get_total_resource', 'get_total_resource'),
            new TwigFunction('dd', 'dd'),
            new TwigFunction('__', '__'),
            new TwigFunction('get_page_url', 'get_page_url'),
            new TwigFunction('apply_filters', 'apply_filters'),
            new TwigFunction('plugin_asset', 'plugin_assets'),
            new TwigFunction('get_posts_by_filter', 'get_posts_by_filter'),
            new TwigFunction('get_next_resource', 'get_next_resource'),
            new TwigFunction('do_action', 'do_action'),
            new TwigFunction('strip_tags', 'strip_tags'),
        ];
    }
}
