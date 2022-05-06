<?php

namespace Juzaweb\CMS\Http\Controllers;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Traits\ResponseMessage;
use TwigBridge\Facade\Twig;

class FrontendController extends Controller
{
    use ResponseMessage;

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

    protected function getPermalinks($base = null): mixed
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
