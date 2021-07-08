<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Spatie\Permission\Exceptions\UnauthorizedException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
      if ($exception instanceof UnauthorizedException) {
      $errors =[
        'code' => $exception->getStatusCode(),
        'message' => $exception->getMessage()
      ];
      return response()->view('errors.'.$exception->getStatusCode(), ['errors' => $errors], $exception->getStatusCode());
      }

      if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
        return redirect('/');
      }
      return parent::render($request, $exception);
    }
}
