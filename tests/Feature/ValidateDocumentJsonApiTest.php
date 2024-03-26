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
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutJsonApiDocumentFormatting();
        
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
    /** @test **/
    public function data_must_be_an_array(): void
    {
        //para peticiones post
        $this->postJson('test_route',[
            'data' => 'string'
        ])
        ->assertJsonApiValidationErrors('data');

        //para peticiones patch
        $this->patchJson('test_route',[
            'data' => 'string'
        ])
        ->assertJsonApiValidationErrors('data');
    }

/** @test **/
    public function data_type_is_required(): void
    {
        //para peticiones post
        $this->postJson('test_route',[
            'data' => [
                'attributes' => []
            ]
        ])
        ->assertJsonApiValidationErrors('data.type');

        //para peticiones patch
        $this->patchJson('test_route',[
            'data' => [
                'attributes' => []
            ]
        ])
        ->assertJsonApiValidationErrors('data.type');
    }

/** @test **/
public function data_attribute_is_required(): void
{
    //para peticiones post
    $this->postJson('test_route',[
        'data' => [
            'type' => 'string'
        ]
    ])
    ->assertJsonApiValidationErrors('data.attributes');

    //para peticiones patch
    $this->patchJson('test_route',[
        'data' => [
            'type' => 'string'
        ]
    ])
    ->assertJsonApiValidationErrors('data.attributes');
}
/** @test **/
public function data_attribute_must_be_an_array(): void
{
    //para peticiones post
    $this->postJson('test_route',[
        'data' => [
            'type' => 'string',
            'attributes' => 'string'
        ]
    ])
    ->assertJsonApiValidationErrors('data.attributes');

    //para peticiones patch
    $this->patchJson('test_route',[
        'data' => [
            'type' => 'string',
            'attributes' => 'string'
        ]
    ])
    ->assertJsonApiValidationErrors('data.attributes');
}
    /** @test **/
    public function data_type_must_be_a_string(): void
    {
        //para peticiones post
        $this->postJson('test_route',[
            'data' => [
                'type' => 1,
                'attributes' => ['name' => 'test']
            ]
        ])
        ->assertJsonApiValidationErrors('data.type');

        //para peticiones patch
        $this->patchJson('test_route',[
            'data' => [
                'type' => 1,
                'attributes' => ['name' => 'test']
            ]
        ])
        ->assertJsonApiValidationErrors('data.type');
    }
        /** @test **/
    public function data_id_is_required(): void
    {
        //para peticiones patch
        $this->patchJson('test_route',[
            'data' => [
                'type' => 'string',
                'attributes' => ['name' => 'test']
            ]
        ])
        ->assertJsonApiValidationErrors('data.id');
    }
    public function data_id_must_be_string(): void
    {
        //para peticiones patch
        $this->patchJson('test_route',[
            'data' => [
                'id' => 1,
                'type' => 'string',
                'attributes' => ['name' => 'test']
            ]
        ])
        ->assertJsonApiValidationErrors('data.id');
    }

     /** @test **/
     public function only_accept_valid_json_api_document(): void
     {
         //para peticiones post
         $this->postJson('test_route',[
            'data' => [
                'type' => 'string',
                'attributes' => [
                    'name' => 'test'
                ]
            ]
         ])->assertSuccessful('data.type');
         
         $this->patchJson('test_route',[
            'data' => [
                'id' => '1',
                'type' => 'string',
                'attributes' => [
                    'name' => 'test'
                ]
            ]
         ])->assertSuccessful('data.type');
 
}
}