<?php

if (!function_exists('is_url')) {
    /**
     * Return true if string is a url
     *
     * @param string|null $url
     * @return bool
     */
    function is_url(?string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }
}

function get_full_url(string $url, string $currentUrl): string
{
    $baseUrl = get_base_url($currentUrl);

    if (is_url($url)) {
        return $url;
    }

    if (str_starts_with($url, '//')) {
        return 'https:' . $url;
    }

    if (str_starts_with($url, '/')) {
        if ($url == '/') {
            return $baseUrl;
        }

        return $baseUrl . $url;
    }

    if (str_starts_with($url, './') && !str_ends_with($currentUrl, '/')) {
        $split = explode('/', $currentUrl);
        $currentUrl = preg_replace("/{$split[count($split) - 1]}/", '', $currentUrl, -1);
    }

    return abs_url($currentUrl . '/' . $url, $currentUrl);
}

function get_base_url(string $url): string
{
    $parse = parse_url($url);
    $scheme = isset($parse['scheme']) ? $parse['scheme'] . '://' : '';
    $host = $parse['host'] ?? '';
    return "{$scheme}{$host}";
}

if (!function_exists('path_url')) {
    function path_url(string $url): string
    {
        if (!is_url($url)) {
            return $url;
        }

        return parse_url($url)['path'];
    }
}

/** Build a URL
 *
 * @param array $parts An array that follows the parse_url scheme
 * @return string
 */
function build_url($parts): string
{
    if (empty($parts['user'])) {
        $url = $parts['scheme'] . '://' . $parts['host'];
    } elseif (empty($parts['pass'])) {
        $url = $parts['scheme'] . '://' . $parts['user'] . '@' . $parts['host'];
    } else {
        $url = $parts['scheme'] . '://' . $parts['user'] . ':' . $parts['pass'] . '@' . $parts['host'];
    }

    if (!empty($parts['port'])) {
        $url .= ':' . $parts['port'];
    }

    if (!empty($parts['path'])) {
        $url .= $parts['path'];
    }

    if (!empty($parts['query'])) {
        $url .= '?' . $parts['query'];
    }

    if (!empty($parts['fragment'])) {
        return $url . '#' . $parts['fragment'];
    }

    return $url;
}

/** Convert a relative path in to an absolute path
 *
 * @param string $path
 * @return string
 */
function abs_path(string $path): string
{
    $path_array = explode('/', $path);

    // Solve current and parent folder navigation
    $translated_path_array = array();
    $i = 0;
    foreach ($path_array as $name) {
        if ($name === '..') {
            unset($translated_path_array[--$i]);
        } elseif (!empty($name) && $name !== '.') {
            $translated_path_array[$i++] = $name;
        }
    }

    return '/' . implode('/', $translated_path_array);
}

/** Convert a relative URL in to an absolute URL
 *
 * @param string $url URL or URI
 * @param string $base Absolute URL
 * @return string
 */
function abs_url(string $url, string $base): string
{
    $url_parts = parse_url($url);
    $base_parts = parse_url($base);

    // Handle the path if it is specified
    if (!empty($url_parts['path'])) {
        // Is the path relative
        if (substr($url_parts['path'], 0, 1) !== '/') {
            if (substr($base_parts['path'], -1) === '/') {
                $url_parts['path'] = $base_parts['path'] . $url_parts['path'];
            } else {
                $url_parts['path'] = dirname($base_parts['path']) . '/' . $url_parts['path'];
            }
        }

        // Make path absolute
        $url_parts['path'] = abs_path($url_parts['path']);
    }

    // Use the base URL to populate the unfilled components until a component is filled
    foreach (['scheme', 'host', 'path', 'query', 'fragment'] as $comp) {
        if (!empty($url_parts[$comp])) {
            break;
        }
        $url_parts[$comp] = $base_parts[$comp];
    }

    return build_url($url_parts);
}

if (!function_exists('is_domain')) {
    function is_domain(string $value): bool
    {
        return (bool) preg_match(
            '/^(?:[a-z0-9](?:[a-z0-9-æøå]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]$/isu',
            $value
        );
    }
}

