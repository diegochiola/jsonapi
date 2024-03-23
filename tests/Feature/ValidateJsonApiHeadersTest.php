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
    //creamos metodo setup
    protected function setUp():void{
        parent::setUp();
        /*Route::any('test_route', function(){ //el any es para hacer todos los tipos de llamados(POST/GET/ETC)
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);*/
        Route::any('test_route', fn() =>'OK')->middleware(ValidateJsonApiHeaders::class);
    }
    
 /** @test **/
    public function accept_header_must_be_present_in_all_requests(): void
    {

        $this->get('test_route')->assertStatus(406);

        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertSuccessful(); //muestra un estado mayor o igual a 200 y menor a 300

    }
//ES NECESARIO COMENTAR TEST ENCIMA DE CADA TEST PARA QUE VSC LOS ENGANCHE  
 /** @test **/
    public function content_type_header_must_be_present_on_all_posts_requests(): void
    {

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
        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415); //deberia devolver un 415
        
        $this->patch('test_route',[], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful(); //muestra un estado mayor o igual a 200 y menor a 300
        
    }
     /** @test **/
    public function content_type_header_must_be_present_in_responses(){
        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json'); 
       
        $this->post('test_route',[], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json'); 

        $this->patch('test_route',[], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json'); 


    }
     /** @test **/
    public function content_type_header_must_not_be_present_in_empty_responses(){
        Route::any('empty_response', fn() => response()->noContent())->middleware(ValidateJsonApiHeaders::class);

        $this->post('empty_response',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type'); 

        $this->patch('empty_response',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type'); 
        
        $this->delete('empty_response',[],[
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type'); 
    }
}

