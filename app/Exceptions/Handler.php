<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
    protected function invalidJson($request, ValidationException $exception){
        //devolver respuesta personalizada:
        //hacer las repsuestas dinamicas sino dara error:
        $title= $exception->getMessage();
       /*
        $errors = []; //contruimos el objeto errors
        foreach($exception->errors() as $field=> $message){
            $pointer = "/".str_replace('.', '/', $field);
            $errors []=  [
                'title' => $title,
                'detail' => $message[0],
                'source' => [
                    'pointer' => $pointer
                ]
                    
                ];
        } */
        //coleccionamos en lugar del foreach
       
        return response()->json([
            'errors' => collect($exception->errors())
            ->map(function($message, $field) use ($title){
               return  [
                'title' => $title,
                'detail' => $message[0],
                'source' => [
                    'pointer' => "/".str_replace('.', '/', $field)
                ]
              ];
            })->values()
        ],422);
    }
}
