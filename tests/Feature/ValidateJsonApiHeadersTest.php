<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;
 /** @test **/
    public function accept_header_must_be_present_in_all_requests(): void
    {
        //probar ruta que este utilizando middelware
        Route::get('test_route', function(){
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);
        $this->get('test_route')->assertStatus(406);

        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertSuccessful(); //muestra un estado mayor o igual a 200 y menor a 300

    }
//ES NECESARIO COMENTAR TEST ENCIMA DE CADA TEST PARA QUE VSC LOS ENGANCHE  
 /** @test **/
    public function content_type_header_must_be_present_on_all_posts_requests(): void
    {

        Route::post('test_route', function(){
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);
        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415); //deberia devolver un 415
        
        $this->post('test_route',[], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful(); //muestra un estado mayor o igual a 200 y menor a 300
        
    }
 /** @test **/
    public function content_type_header_must_be_present_on_all_post_requests(): void
    {

        Route::post('test_route', function(){
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);
        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415); //deberia devolver un 415
        
        $this->post('test_route',[], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful(); //muestra un estado mayor o igual a 200 y menor a 300
        
    }
 /** @test **/
    public function content_type_header_must_be_present_on_all_patch_requests(): void
    {

        Route::patch('test_route', function(){
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);
        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415); //deberia devolver un 415
        
        $this->patch('test_route',[], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful(); //muestra un estado mayor o igual a 200 y menor a 300
        
    }
}
