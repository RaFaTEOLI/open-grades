<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

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
    protected $dontFlash = ["password", "password_confirmation"];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            if ($request->is("api/*")) {
                return response()->json(["error" => __("informative.unauthorized")], $exception->getStatusCode());
            } else {
                return redirect("/403");
            }
        } elseif ($exception instanceof HttpException && $exception->getStatusCode() == 401) {
            if ($request->is("api/*")) {
                return response()->json(["error" => __("informative.unauthorized")], $exception->getStatusCode());
            } else {
                return redirect("/401");
            }
        }
        return parent::render($request, $exception);
    }
}
