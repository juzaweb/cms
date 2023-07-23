<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 *
 * Created by JUZAWEB.
 * Date: 5/25/2021
 * Time: 10:10 PM
 */

namespace Juzaweb\CMS\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Traits\ResponseMessage;

class BackendController extends Controller
{
    use ResponseMessage;

    /**
     * @var string $template Support blade,inertia
     */
    protected string $template = 'blade';

    public function callAction($method, $parameters)
    {
        do_action(Action::BACKEND_CALL_ACTION, $method, $parameters);

        return parent::callAction($method, $parameters);
    }

    protected function view(?string $view = null, array $data = []): View|Response
    {
        return match ($this->template) {
            'inertia' => $this->inertiaViewRender($view, $data),
            default => view($view, $data),
        };
    }

    protected function inertiaViewRender(?string $view = null, array $data = []): Response
    {
        $view = Str::replace('cms::backend.', '', $view);
        $view = Str::replace('.', '/', $view);
        return Inertia::render($view, $data);
    }

    protected function addBreadcrumb(array $item, $name = 'admin'): void
    {
        add_filters(
            $name.'_breadcrumb',
            function ($items) use ($item) {
                $items[] = $item;

                return $items;
            }
        );
    }

    protected function addMessage(
        string $key,
        string|array $message,
        string $type = 'warning'
    ): void {
        $message = is_string($message) ? [$message] : $message;

        add_backend_message(
            $key,
            $message,
            $type
        );
    }
}
