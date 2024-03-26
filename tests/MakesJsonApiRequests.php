<?php

namespace Tests;

use Closure;
use PHPUnit\Framework\Assert as PHPUnit;
use \PHPUnit\Framework\ExpectationFailedException;
use Illuminate\Support\Str;

trait MakesJsonApiRequests{
   
    public function json($method, $uri, array $data = [], array $headers = [], $options = 0) : \Illuminate\Testing\TestResponse
    {
    $headers['accept'] = 'application/vnd.api+json';
    $formattedData['data']['attributes']= $data;
    $formattedData['data']['type'] = (string)Str::of($uri)->after('api/v1');

    return parent::json($method, $uri,$formattedData, $headers);

   }

   public function postJson($uri, array $data = [], array $headers = [], $options = 0): \Illuminate\Testing\TestResponse{
    $headers['content-type'] = 'application/vnd.api+json';
    return parent::postJson($uri, $data, $headers);
   
   }
   public function patchJson($uri, array $data = [], array $headers = [], $options = 0): \Illuminate\Testing\TestResponse{
    $headers['content-type'] = 'application/vnd.api+json';
    return parent::patchJson($uri, $data, $headers);
   
   }
   protected function assertJsonApiValidationErrors(): Closure {
    return function ($attribute){
        /** @var TestResponse $this */
        //operador ternario 
       $pointer =  Str::of($attribute)->startsWith('data') 
       ? "/".str_replace('.', '/', $attribute) 
       : "/data/attributes/{$attribute}";
        try{
            $this->assertJsonFragment([
                'source' => ['pointer' => $pointer] //hacerlo dinamico "/data/attributes/{$attribute}"
            ]);
        }catch (ExpectationFailedException $e){
            //dd($e); //inspeccionamos para ver de que trata
            PHPUnit::fail("Failed to find a JSON:API validation error for Key: '{$attribute}'". 
            PHP_EOL.PHP_EOL.
            $e->getMessage());
        }
       try{

       }catch (ExpectationFailedException $e){
            //dd($e); //inspeccionamos para ver de que trata
            PHPUnit::fail("Failed to find a valid JSON:API error response".  //modificar el mensaje como nos parezca mejor
            PHP_EOL.PHP_EOL.
            $e->getMessage());
        }
        
        $this->assertJsonStructure([
            'errors' => [
                ['title', 'detail', 'source' => ['pointer']]
            ]
            ]);
       
        $this->assertHeader(
                'content-type', 'application/vnd.api+json'
            
            )->assertStatus(422);   
    };
   }
}