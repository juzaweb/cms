<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 *
 * Created by JUZAWEB.
 * Date: 5/25/2021
 * Time: 10:10 PM
 */

namespace Juzaweb\CMS\Http\Controllers;

use Exception;
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

    /**
     * A description of the entire PHP function.
     *
     * @param string|null $view The name of the view to render. Defaults to null.
     * @param array $data An associative array of data to pass to the view. Defaults to an empty array.
     * @return View|Response Returns an instance of the View or Response class.
     */
    protected function view(?string $view = null, array $data = []): View|Response
    {
        return match ($this->template) {
            'inertia' => $this->inertiaViewRender($view, $data),
            default => view($view, $data),
        };
    }

    /**
     * Renders an Inertia view with optional data.
     *
     * @param ?string $view The name of the view to render. If null, the default view will be used.
     * @param array $data Optional data to pass to the view.
     * @return Response The rendered Inertia view.
     */
    protected function inertiaViewRender(?string $view = null, array $data = []): Response
    {
        // Remove backend blade prifix
        $view = Str::replace('cms::backend.', '', $view);

        // Replate . to /
        $view = Str::replace('.', '/', $view);

        // Render Inertia view
        return Inertia::render($view, $data);
    }

    /**
     * Adds a breadcrumb item to the specified breadcrumb list.
     *
     * @param array $item The breadcrumb item to be added.
     * @param string  $name The name of the breadcrumb list. Default is 'admin'.
     * @return void
     *@throws Exception If there is an error adding the breadcrumb item.
     */
    protected function addBreadcrumb(array $item, string $name = 'admin'): void
    {
        add_filters(
            $name.'_breadcrumb',
            function ($items) use ($item) {
                $items[] = $item;

                return $items;
            }
        );
    }

    /**
     * Adds a message to the backend message system.
     *
     * @param string $key The key for the message.
     * @param string|array $message The message or an array of messages.
     * @param string $type The type of the message (default: 'warning').
     * @throws Exception If an error occurs while adding the message.
     * @return void
     */
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
