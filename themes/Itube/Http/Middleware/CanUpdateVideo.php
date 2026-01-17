<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanUpdateVideo
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $video = $request->route('video');

        if ($video->created_by != $request->user()->id) {
            abort(403, __('itube::translation.you_do_not_have_permission_to_update_this_video'));
        }

        return $next($request);
    }
}
