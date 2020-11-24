<?php

namespace App\Exceptions;

use App\Http\Responses\Api\Response;
use Illuminate\Auth\AuthenticationException;
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

    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof RouteNotFoundException || $exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
        elseif ($exception instanceof ValidationException) {
            return $this->validationExceptionToResponse($exception, $request);
        }

        return parent::render($request, $e);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return Response::make()->addErrorMessage($exception->getMessage(), 401)
            ->setStatusCode(401)
            ->toResponse($request);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function validationExceptionToResponse(ValidationException $exception, $request)
    {
        return Response::make()->addErrorMessage($exception->getMessage(), 422)
            ->setValidation($exception->errors())
            ->setStatusCode(422)
            ->toResponse($request);
    }
}
