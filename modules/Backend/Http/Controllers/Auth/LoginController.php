<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Http\Controllers\Controller;
use Juzaweb\CMS\Traits\Auth\AuthLoginForm;

class LoginController extends Controller
{
    use AuthLoginForm;

    protected bool $themeView = false;

    public function callAction($method, $parameters)
    {
        if (request()->route()->getName() == 'login') {
            if (view()->exists('theme::auth.login')) {
                $this->themeView = true;

                do_action(Action::FRONTEND_CALL_ACTION, $method, $parameters);

                do_action(Action::WIDGETS_INIT);

                do_action(Action::BLOCKS_INIT);
            }
        }

        return parent::callAction($method, $parameters);
    }

    protected function getViewForm(): string
    {
        if ($this->themeView) {
            return 'theme::auth.login';
        }

        return 'cms::auth.login';
    }
}
