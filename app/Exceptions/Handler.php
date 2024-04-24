<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception instanceof HttpException && $exception->getStatusCode() == 404) {
                return response()->view('admin.error.404', [], 404);
            }
            if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
                return response()->view('admin.error.500', [], 500);
            }
            if ($exception instanceof HttpException && $exception->getStatusCode() == 400) {
                return response()->view('admin.error.400', [], 400);
            }
            if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
                return response()->view('admin.error.403', [], 403);
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
