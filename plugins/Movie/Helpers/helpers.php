<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:06 PM
 */

use Plugins\Movie\Models\Ads;
use Plugins\Movie\Models\Category\Countries;
use Plugins\Movie\Models\Category\Genres;
use Plugins\Movie\Models\Category\Types;
use Plugins\Movie\Models\Movie\Movies;

function get_ads(string $key) {
    $ads = Ads::where('key', '=', $key)
        ->where('status', '=', 1)
        ->first(['body']);
    if (empty($ads)) {
        return false;
    }

    return $ads->body;
}

function genre_info($id) {
    return Genres::where('id', '=', $id)
        ->first(['id', 'name']);
}

function type_info($id) {
    return Types::where('id', '=', $id)
        ->first(['id', 'name']);
}

function country_info($id) {
    return Countries::where('id', '=', $id)
        ->first(['id', 'name']);
}

function genre_setting($setting) {
    $order = isset($setting->order) ? $setting->order : 'id_DESC';
    $limit = isset($setting->limit) ? intval($setting->limit) : 6;
    $ctype = isset($setting->ctype) ? intval($setting->ctype) : 1;
    $format = isset($setting->format) ? intval($setting->format) : 0;
    $order = explode('_', $order);
    $result = new stdClass();

    if (empty($ctype)) {
        $ctype = 1;
    }

    if (!in_array($order[0], ['updated_at', 'view'])) {
        $order[0] = 'id';
    }

    if ($order[0] == 'view') {
        $order[0] = 'views';
    }

    if (!in_array($order[1], ['ASC', 'DESC'])) {
        $order[1] = 'DESC';
    }

    $query = Movies::query();
    $query->select([
        'id',
        'name',
        'other_name',
        'short_description',
        'thumbnail',
        'slug',
        'views',
        'video_quality',
        'year',
        'genres',
        'countries',
        'tv_series',
        'current_episode',
        'max_episode',
    ]);

    $query->where('status', '=', 1);

    if ($format) {
        $query->where('tv_series', '=', $format - 1);
    }

    if ($ctype == 1) {
        if (@$setting->genre) {
            $query->whereRaw('find_in_set(?, genres)', [$setting->genre]);
            $result->url = route('genre', @Genres::find($setting->genre)->slug);
        }
    }

    if ($ctype == 2) {
        if (@$setting->type) {
            $query->where('type_id', '=', $setting->type);
            $result->url = route('type', @Types::find($setting->type)->slug);
        }
    }

    if ($ctype == 3) {
        if (@$setting->country) {
            $query->whereRaw('find_in_set(?, countries)', [$setting->country]);
            $result->url = route('country', @Countries::find($setting->country)->slug);
        }
    }

    if (empty($result->url)) {
        if ($format == 1) {
            $result->url = route('movies');
        }

        if ($format == 2) {
            $result->url = route('tv_series');
        }

        if (empty($format)) {
            $result->url = route('latest_movies');
        }
    }

    $query->orderBy($order[0], $order[1]);
    $query->limit($limit);

    $result->items = $query->get();
    $result->title = @$setting->title;
    return $result;
}

function child_genres_setting($setting) {
    try {
        $query = Genres::query();
        $query->whereIn('id', $setting);
        $query->where('status', '=', 1);
        return $query->get(['id', 'name', 'slug']);
    }
    catch (Exception $exception) {
        return [];
    }
}

function get_youtube_id($url) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    if (@$match[1]) {
        return $match[1];
    }
    return false;
}

function get_vimeo_id($url) {
    $regs = [];
    $id = '';
    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
        $id = $regs[3];
    }
    return $id;
}

function get_google_drive_id(string $url) {
    return explode('/', $url)[5];
}

function is_active_movie_menu() {
    $menus = [
        'movies',
        'tv-series',
        'genres',
        'countries',
        'types',
        'stars',
        'video-qualities',
    ];
    foreach ($menus as $menu) {
        if (request()->is('admin-cp/'. $menu .'*')) {
            return true;
        }
    }
    return false;
}
