<?php

namespace Juzaweb\Multilang\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class Multilang
{
    private $url;
    
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*$this->url->defaults(
            [
                'locale' => $request->getHost(),
            ]
        );*/

        $type = get_config('mlla_type', 'session');
        if ($type == 'session') {
            $locale = $request->get('locale');
            if ($locale) {
                $this->setLocaleSession($locale);
                return redirect()->back();
            }
        }

        if ($locale = $this->getLocaleByRequest($request, $type)) {
            App::setLocale($locale);
        }

        return $next($request);
    }

    protected function getLocaleByRequest(Request $request, string $type)
    {
        if ($type == 'session') {
            if ($locale = $this->getLocaleSession()) {
                return $locale;
            }

            return false;
        }

        if ($type == 'domain') {
            $domains = get_config('mlla_subdomain');
            $domain = $domains[$request->getHost()] ?? null;

            if ($domain) {
                return $domain['language'];
            }
        }

        return false;
    }

    protected function getLocaleSession()
    {
        $locale = session()->get('jw_locale');
        if ($locale) {
            return $locale;
        }

        $locale = Cookie::get('jw_locale');
        if ($locale) {
            $this->setLocaleSession($locale);
            return $locale;
        }

        return false;
    }

    protected function setLocaleSession($locale)
    {
        session()->put('jw_locale', $locale);
        Cookie::queue('jw_locale', $locale, time() + 2592000);
    }
}
