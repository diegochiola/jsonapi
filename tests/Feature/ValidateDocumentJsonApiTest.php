<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;

use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateDocumentJsonApiTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp():void{
        parent::setUp();
        /*Route::any('test_route', function(){ //el any es para hacer todos los tipos de llamados(POST/GET/ETC)
            return 'OK';
        })->middleware(ValidateJsonApiHeaders::class);*/
        Route::any('test_route', fn() =>'OK')->middleware(ValidateJsonApiDocument::class);
    }

 /** @test **/
    public function data_is_required(): void
    {
        //para peticiones post
        $this->postJson('test_route',[])
        ->assertJsonApiValidationErrors('data');

        //para peticiones patch
        $this->patchJson('test_route',[])
        ->assertJsonApiValidationErrors('data');
    }
}
