<?php

namespace Juzaweb\Http\Controllers;

use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\Traits\ResponseMessage;
use TwigBridge\Facade\Twig;
use Illuminate\Support\Facades\View;

class FrontendController extends Controller
{
    use ResponseMessage;

    public function __construct()
    {
        //parent::__construct();

        View::composer('*', function ($view) {
            global $jw_user;

            $user = $jw_user ? (new UserResource($jw_user))->toArray(request()) : null;

            $domains = explode(',', config('app.site_domains'));

            $view->with('user', $user);
            $view->with('is_admin', $user ? $user['is_admin'] : false);
            $view->with('auth', $user ? true : false);
            $view->with('guest', $user ? false : true);
            $view->with('site_domains', $domains);
        });
    }

    public function callAction($method, $parameters)
    {
        /**
         * Action after call action frontend
         * Add action to this hook add_action('frontend.call_action', $callback)
         */
        do_action(Action::FRONTEND_CALL_ACTION, $method, $parameters);

        do_action(Action::WIDGETS_INIT);

        do_action(Action::BLOCKS_INIT);

        return parent::callAction($method, $parameters);
    }

    protected function getPermalinks($base = null)
    {
        if ($base) {
            return collect(HookAction::getPermalinks())
                ->where('base', $base)
                ->first();
        }

        return collect(HookAction::getPermalinks());
    }

    protected function view($view, $params = [])
    {
        return Twig::render($view, $params);
    }
}
