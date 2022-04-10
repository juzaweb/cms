<?php

require __DIR__ . '/html_dom.php';
require __DIR__ . '/data_helpers.php';
require __DIR__ . '/plugin.php';
require __DIR__ . '/theme.php';

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Juzaweb\CMS\Facades\Config;
use Juzaweb\CMS\Facades\Hook;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\CMS\Facades\XssCleaner;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\Breadcrumb;

if (! function_exists('e_html')) {
    function e_html($str)
    {
        return XssCleaner::clean($str);
    }
}

if (! function_exists('get_client_ip')) {
    /**
     * Get client ip
     *
     * @return string
     * */
    function get_client_ip()
    {
        // Check Cloudflare support
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        // Get ip from server
        return request()->ip();
    }
}

if (! function_exists('get_config')) {
    /**
     * Get DB config
     *
     * @param string $key
     * @param mixed $default
     * @return string|array
     */
    function get_config($key, $default = null)
    {
        try {
            return Config::getConfig($key, $default);
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (! function_exists('get_configs')) {
    /**
     * Get multi DB configs
     *
     * @param array $keys
     * @param mixed $default
     * @return array
     */
    function get_configs($keys, $default = null)
    {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = get_config($key, $default);
        }

        return $data;
    }
}

if (! function_exists('set_config')) {
    /**
     * Set DB config
     *
     * @param string $key
     * @param string|array $value
     * @return \Juzaweb\CMS\Models\Config
     */
    function set_config($key, $value)
    {
        return Config::setConfig($key, $value);
    }
}

if (! function_exists('generate_token')) {
    /**
     * Generate static by token
     *
     * @param string $string
     * @return string
     */
    function generate_token($string)
    {
        $month = date('Y-m');
        $ip = get_client_ip();
        $key = 'ADA&$sdss$#&%^23vx' . config('app.key');

        return md5($key . $month . $key) . md5($key . $ip . $string);
    }
}

if (! function_exists('check_token')) {
    /**
     * Check static token
     *
     * @param string $token
     * @param string $string
     * @return bool
     */
    function check_token($token, $string)
    {
        if (generate_token($string) == $token) {
            return true;
        }

        return false;
    }
}

if (! function_exists('sub_words')) {
    function sub_words($string, int $words = 20)
    {
        return Str::words($string, $words);
    }
}

if (! function_exists('is_url')) {
    /**
     * Return true if string is a url
     *
     * @param string $url
     * @return bool
     */
    function is_url($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }
}

if (! function_exists('count_unread_notifications')) {
    /**
     * Count number unread notifications
     *
     * @return int
     */
    function count_unread_notifications()
    {
        $user = Auth::user();
        if (method_exists($user, 'unreadNotifications')) {
            return $user->unreadNotifications()->count(['id']);
        }

        return 0;
    }
}

function user_avatar($user = null)
{
    if ($user) {
        if (! $user instanceof User) {
            $user = User::find($user);
        }

        return $user->getAvatar();
    }

    if (Auth::check()) {
        /**
         * @var User $user
         */
        $user = Auth::user();

        return $user->getAvatar();
    }

    return asset('jw-styles/juzaweb/images/thumb-default.png');
}

if (! function_exists('jw_breadcrumb')) {
    function jw_breadcrumb($name, $addItems = [])
    {
        $items = apply_filters($name . '_breadcrumb', []);

        if ($addItems) {
            foreach ($addItems as $addItem) {
                $items[] = $addItem;
            }
        }

        return Breadcrumb::render($name, $items);
    }
}

if (! function_exists('combine_pivot')) {
    function combine_pivot($entities, $pivots = [])
    {
        // Set array
        $pivotArray = [];
        // Loop through all pivot attributes
        foreach ($pivots as $pivot => $value) {
            // Combine them to pivot array
            $pivotArray += [$pivot => $value];
        }
        // Get the total of arrays we need to fill
        $total = count($entities);
        // Make filler array
        $filler = array_fill(0, $total, $pivotArray);
        // Combine and return filler pivot array with data
        return array_combine($entities, $filler);
    }
}

if (! function_exists('path_url')) {
    function path_url(string $url)
    {
        if (! is_url($url)) {
            return $url;
        }

        return parse_url($url)['path'];
    }
}

if (! function_exists('upload_url')) {
    /**
     * Get file upload url in public storage
     *
     * @param string $path
     * @param string $default Default path if file not exists
     * @return string
     */
    function upload_url($path, $default = null)
    {
        if (is_url($path)) {
            return $path;
        }
        
        if (empty($path)) {
            if ($default) {
                return $default;
            }
    
            return asset('jw-styles/juzaweb/images/thumb-default.png');
        }

        $storage = Storage::disk('public');
        if ($storage->exists($path)) {
            return $storage->url($path);
        }

        if ($default) {
            return $default;
        }

        return asset('jw-styles/juzaweb/images/thumb-default.png');
    }
}

if (! function_exists('random_string')) {
    function random_string(int $length = 16)
    {
        return Str::random($length);
    }
}

if (! function_exists('is_json')) {
    /**
     * Rerutn true if string is a json
     *
     * @param string $string
     * @return bool
     */
    function is_json($string)
    {
        try {
            json_decode($string);

            return json_last_error() === JSON_ERROR_NONE;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

if (! function_exists('do_action')) {
    /**
     * JUZAWEB CMS: Do action hook
     *
     * @param string $tag
     * @param mixed ...$args Additional parameters to pass to the callback functions.
     * @return void
     * */
    function do_action($tag, ...$args)
    {
        Hook::action($tag, ...$args);
    }
}

if (! function_exists('add_action')) {
    /**
     * JUZAWEB CMS: Add action to hook
     *
     * @param string $tag The name of the filter to hook the $function_to_add callback to.
     * @param callable $callback The callback to be run when the filter is applied.
     * @param int $priority Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action. Default 20.
     * @param int $arguments Optional. The number of arguments the function accepts. Default 1.
     * @return void
     */
    function add_action($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addAction($tag, $callback, $priority, $arguments);
    }
}

if (! function_exists('apply_filters')) {
    /**
     * JUZAWEB CMS: Apply filters to value
     *
     * @param string $tag The name of the filter hook.
     * @param mixed  $value The value to filter.
     * @param mixed  ...$args Additional parameters to pass to the callback functions.
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    function apply_filters($tag, $value, ...$args)
    {
        return Hook::filter($tag, $value, ...$args);
    }
}

if (! function_exists('add_filters')) {
    /**
     * @param string $tag The name of the filter to hook the $function_to_add callback to.
     * @param callable $callback The callback to be run when the filter is applied.
     * @param int $priority Optional. Used to specify the order in which the functions
     *                                  associated with a particular action are executed.
     *                                  Lower numbers correspond with earlier execution,
     *                                  and functions with the same priority are executed
     *                                  in the order in which they were added to the action. Default 20.
     * @param int $arguments   Optional. The number of arguments the function accepts. Default 1.
     * @return void
     */
    function add_filters($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addFilter($tag, $callback, $priority, $arguments);
    }
}

if (! function_exists('is_active_route')) {
    /**
     * Set the active class to the current opened menu.
     *
     * @param  string|array $route
     * @param  string       $className
     * @return string
     */
    function is_active_route($route, $className = 'active')
    {
        if (is_array($route)) {
            return in_array(Route::currentRouteName(), $route) ? $className : '';
        }

        if (Route::currentRouteName() == $route) {
            return $className;
        }

        if (strpos(URL::current(), $route)) {
            return $className;
        }

        return false;
    }
}

if (! function_exists('jw_date_format')) {
    /**
     * Format date to global format cms
     *
     * @param string $date
     * @param int $format // JW_DATE || JW_DATE_TIME
     * @return string
     */
    function jw_date_format($date, $format = JW_DATE_TIME)
    {
        if ($date instanceof Carbon) {
            $date = $date->format('Y-m-d H:i:s');
        }

        $dateFormat = get_config('date_format', 'F j, Y');
        switch ($format) {
            case JW_DATE:
                return date($dateFormat, $date);
        }

        $timeFormat = get_config('time_format', 'g:i a');

        return date($dateFormat . ' ' . $timeFormat, strtotime($date));
    }
}

if (! function_exists('jw_current_user')) {
    /**
     * Get current login user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|User|null
     */
    function jw_current_user()
    {
        return Auth::user();
    }
}

if (! function_exists('jw_get_page')) {
    function jw_get_page($id)
    {
        return Post::find($id);
    }
}

if (! function_exists('array_only')) {
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string $keys
     * @return array
     */
    function array_only($array, $keys)
    {
        return Arr::only($array, $keys);
    }
}

if (! function_exists('array_except')) {
    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    function array_except($array, $keys)
    {
        return Arr::except($array, $keys);
    }
}

if (! function_exists('get_enqueue_scripts')) {
    function get_enqueue_scripts($inFooter = false)
    {
        return HookAction::getEnqueueScripts($inFooter);
    }
}

if (! function_exists('get_enqueue_styles')) {
    function get_enqueue_styles($inFooter = false)
    {
        return HookAction::getEnqueueStyles($inFooter);
    }
}

if (! function_exists('jw_get_select_options')) {
    function jw_get_select_options($data)
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $value['label'];
            } else {
                $result[$key] = $value->get('label');
            }
        }

        return $result;
    }
}

if (! function_exists('str_words_length')) {
    function str_words_length($string, $words, $max_length)
    {
        while (strlen($string) > $max_length) {
            $string = Str::words($string, $words);
            $words--;
        }

        return $string;
    }
}

if (! function_exists('recursive_level_model')) {
    function recursive_level_model(&$level, $model, $limit = 5)
    {
        if ($level > $limit) {
            $level = 0;

            return;
        }

        if ($model->parent) {
            $level++;
            recursive_level_model($level, $model->parent);
        }
    }
}

if (! function_exists('get_version_by_tag')) {
    function get_version_by_tag($tag)
    {
        return str_replace('v', '', $tag);
    }
}

if (! function_exists('get_backend_message')) {
    function get_backend_message()
    {
        return get_config('backend_messages', []);
    }
}

if (! function_exists('add_backend_message')) {
    function add_backend_message($key, $messages = [], $status = 'success')
    {
        if (! is_array($messages)) {
            $messages = [$messages];
        }

        $data = get_backend_message();
        foreach ($messages as $message) {
            $id = Str::uuid()->toString();
            $data[$id] = [
                'id' => $id,
                'key' => $key,
                'status' => $status,
                'message' => $message
            ];
        }

        set_config('backend_messages', $data);
    }
}

if (! function_exists('remove_backend_message')) {
    function remove_backend_message($key)
    {
        $data = collect(get_backend_message());
        $keys = $data->where('key', $key)->keys()->toArray();
        $data = $data->forget($keys)->all();
        set_config('backend_messages', $data);
    }
}

if (! function_exists('is_admin')) {
    /**
     * @param \Juzaweb\CMS\Models\User|null $user
     * @return bool
     */
    function is_admin($user = null)
    {
        if (empty($user)) {
            /**
             * @var \Juzaweb\CMS\Models\User $jw_user
             */
            global $jw_user;

            $user = $jw_user;
        }

        if (empty($user)) {
            return false;
        }

        return $user->isAdmin();
    }
}

if (!function_exists('has_permission')) {
    /**
     * @param \Juzaweb\CMS\Models\User|null $user
     * @return bool
     */
    function has_permission($user = null)
    {
        if (empty($user)) {
            /**
             * @var \Juzaweb\CMS\Models\User $jw_user
             */
            global $jw_user;

            $user = $jw_user;
        }
        
        if (empty($user)) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $user->hasPermission();
    }
}

if (!function_exists('collect_metas')) {
    function collect_metas(array $metas)
    {
        return collect($metas)
            ->mapWithKeys(function ($item, $key) {
                $default = [
                    'type' => 'text',
                    'sidebar' => false,
                    'visible' => true,
                ];

                if (is_array($item)) {
                    $default['label'] = trans("cms::app.{$key}");
                    return [$key => array_merge($default, $item)];
                } else {
                    $default['label'] = trans("cms::app.{$item}");
                    return [$item => $default];
                }
            });
    }
}

if (!function_exists('get_youtube_id')) {
    function get_youtube_id($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        if (@$match[1]) {
            return $match[1];
        }
        return false;
    }
}

if (!function_exists('get_vimeo_id')) {
    function get_vimeo_id($url)
    {
        $regs = [];
        $id = '';
        if (preg_match(
            '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im',
            $url,
            $regs
        )) {
            $id = $regs[3];
        }
        return $id;
    }
}

if (function_exists('get_google_drive_id')) {
    function get_google_drive_id(string $url)
    {
        return explode('/', $url)[5];
    }
}

if (!function_exists('remove_query_url')) {
    function remove_query_url(string $url)
    {
        return explode('?', $url)[0];
    }
}

function format_size_units($bytes, $decimals = 2)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, $decimals) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, $decimals) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, $decimals) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function convert_linux_path(string $path)
{
    return str_replace(
        '\\',
        '/',
        $path
    );
}

function seo_string($string, $chars = 70)
{
    $string = strip_tags($string);
    $string = str_replace(["\n", "\t"], '', $string);
    $string = html_entity_decode($string, ENT_HTML5);
    return sub_char($string, $chars);
}

function jw_basename($name)
{
    $base = basename($name);
    $base = explode('?', $base)[0];
    if (empty($base)) {
        $base = Str::random(10);
    }
    return $base;
}

function parse_price_format($price)
{
    $price = str_replace(',', '', $price);
    $price = (float) $price;
    return $price;
}

function get_full_url($url, $baseUrl)
{
    if (is_url($url)) {
        return $url;
    }

    if (substr($url, 0, 1) == '/') {
        return $baseUrl . $url;
    }

    return $baseUrl .'/'. $url;
}

function sub_char($str, $n, $end = '...')
{
    if (strlen($str) < $n) {
        return $str;
    }
    
    $html = mb_substr($str, 0, $n);
    $html = mb_substr($html, 0, mb_strrpos($html, ' '));
    return $html . $end;
}

function cache_prefix($name)
{
    return 'juzaweb_' . $name;
}

if (!function_exists('admin_url')) {
    function admin_url($path = '', $parameters = [], $secure = null)
    {
        if ($path) {
            return url(
                config('juzaweb.admin_prefix') .'/'. ltrim($path, '/'),
                $parameters,
                $secure
            );
        }
        
        return url(config('juzaweb.admin_prefix'), $parameters, $secure);
    }
}
