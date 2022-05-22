<?php

namespace Juzaweb\CMS\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(
            function (Throwable $e) {
                //
            }
        );
    }

    /**
     * Report or log an exception.
     *
     * @param  Throwable $exception
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->is404Exception($exception)) {
            if ($request->is(config('juzaweb.admin_prefix') . '/*')) {
                return response()->view('cms::404', [], 404);
            }

            if (view()->exists(theme_viewname('theme::404'))) {
                return response()->view(
                    theme_viewname('theme::404'),
                    [],
                    404
                );
            }

            return response()->view(
                'cms::404',
                [],
                404
            );
        }

        return parent::render($request, $exception);
    }

    protected function is404Exception($exception)
    {
        switch ($exception) {
            case $exception instanceof NotFoundHttpException:
                return true;
            case $exception instanceof ModelNotFoundException:
                return true;
        }

        return false;
    }
}
