<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Http\Controllers\Controller;
use Juzaweb\CMS\Traits\Auth\AuthRegisterForm;

class RegisterController extends Controller
{
    use AuthRegisterForm;

    protected bool $themeView = false;

    public function callAction($method, $parameters)
    {
        if (request()->route()->getName() == 'register') {
            if (view()->exists('theme::auth.register')) {
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
            return 'theme::auth.register';
        }

        return 'cms::auth.register';
    }
}
