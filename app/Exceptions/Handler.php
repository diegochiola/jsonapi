<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use App\Http\Responses\JsonApiValidationErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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

    //sobreescribimos el metodo invalid json
    protected function invalidJson($request, ValidationException $exception): JsonApiValidationErrorResponse{
        return new JsonApiValidationErrorResponse($exception);
       
    }
}
