<?php

namespace App\Exceptions;

use App\Http\Responses\Api\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
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
        //
    }

    public function render($request, Throwable $e)
    {
        // TODO: Bring to the one response type
        if ($e instanceof RouteNotFoundException) {
            return Response::make([
                'errors' => [
                    'status' => 401,
                    'message' => 'Unauthenticated',
                ]
            ], 401);
        }
        elseif ($e instanceof ValidationException) {
            return Response::make([
                'errors' => [
                    'status' => 400,
                    'message' => $e->getMessage()
                ],
                'validator' => $e->validator->errors(),
            ]);
        }

        return parent::render($request, $e);
    }
}
