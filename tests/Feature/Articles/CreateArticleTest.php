<?php

namespace Tests\Feature\Articles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use Illuminate\Testing\TestResponse;
use Tests\MakesJsonApiRequests;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase; //hace que cada vez que se ejecute un test comience con la base de datos en blanco
 
protected function setUp():void{
    parent::setUp();
     //Macro
     TestResponse::macro(
        'assertJsonApiValidationErrors', 
        function($attribute){
            /** @var TestResponse $this */
            $this->assertJsonStructure([
                'errors' => [
                    ['title', 'detail', 'source' => ['pointer']]
                ]
                ])->assertJsonFragment([
                    'source' => ['pointer' => "/data/attributes/{$attribute}"]
                ])->assertHeader(
                    'content-type', 'application/vnd.api+json'
                
                )->assertStatus(422);
        });
}
    /** @test **/
    public function can_create_articles()
    {
        //
        //$this->withoutExceptionHandling();
        $response = $this->postJson(route('api.v1.articles.store'), [ 
                    'title' =>'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo'
               
            
        ])->assertCreated();

        $article = Article::first(); //articulo creados mas arriba
        //para verificar los header de las respuesta
        $response->assertHeader(
            'Location',
            route('api.v1.articles.show', $article)
        );

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string)$article->getRouteKey(),
                'attributes' => [
                    'title' =>'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo'
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ]
        ]);
    }

 /** @test **/
 public function title_is_required()
 {
     //
     //$this->withoutExceptionHandling();
     $this->postJson(route('api.v1.articles.store'), [
                 // No se proporciona el campo 'title'
                 'slug' => 'nuevo-articulo',
                 'content' => 'Contenido del articulo'   
     ])->assertJsonApiValidationErrors('title');

    

/*
     $response->assertJsonStructure([
        'errors' => [
            ['title', 'detail', 'source' => ['pointer']]
        ]
        ])->assertJsonFragment([
            'source' => ['pointer' => '/data/attributes/title']
        ])->assertHeader(
            'content-type', 'application/vnd.api+json'
        
        )->assertStatus(422);
        */
     //comentamos la linea de abajo
     //$response->assertJsonApiValidationErrors('title');
     
 }
//test ara que el titulo tenga al menos 4 caracteres:
/** @test **/
public function title_must_have_at_least_4_characters()
{
    //
    //$this->withoutExceptionHandling();
    $response = $this->postJson(route('api.v1.articles.store'), [
        
                'title' => 'TRE', //enviamos titulo con 3 caracteres para que salte el error
                'slug' => 'nuevo-articulo',
                'content' => 'Contenido del articulo'
        
        //])->dump(); para imprimir respuesta
    ])->assertJsonApiValidationErrors('title');        /*->dump()   para imprimir respuesta json*/;
    //$response->assertJsonApiValidationErrors('title');
    
}
/** @test **/
public function slug_is_required()
{
    //$this->withoutExceptionHandling();
    $response = $this->postJson(route('api.v1.articles.store'), [
        
                // No se proporciona el campo 'sluf'
                'title' => 'Nuevo Articulo',
                'content' => 'Contenido del articulo'
        
    ])->assertJsonApiValidationErrors('slug');
    //$response->assertJsonApiValidationErrors('slug');
}

/** @test **/
public function content_is_required()
{
    //
    //$this->withoutExceptionHandling();
    $response = $this->postJson(route('api.v1.articles.store'), [
                // No se proporciona el campo 'content'
                'title' => 'Nuevo Articulo',
                'slug' => 'nuevo-articulo'
    ])->assertJsonApiValidationErrors('content');
    //esperamos el error de validacion en el campo content
    //$response->assertJsonApiValidationErrors('content');
    
}

}
