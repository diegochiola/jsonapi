<?php
namespace App\Http\Responses;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;

class JsonApiValidationErrorResponse extends JsonResponse{

public function __contruct(ValidationException $exception){
    $title= $exception->getMessage();
    $data = [
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
    ]; 
    $headers = [
        'content-type' => 'application/vnd.api+json'
    ];
    
    parent::__construct($data, 422, $headers);
}






}