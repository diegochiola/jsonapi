<?php

namespace Tests\Feature\Articles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase; //hace que cada vez que se ejecute un test comience con la base de datos en blanco
 /** @test **/
    public function can_create_articles()
    {
        //
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.v1.articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' =>'Nuevo articulo',
                    'slug' => 'nuevo-articulo',
                    'content' => 'Contenido del articulo'
                ]
            ]
        ]);
        $response->assertCreated();
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
     $response = $this->postJson(route('api.v1.articles.create'), [
         'data' => [
             'type' => 'articles',
             'attributes' => [
                 
                 'slug' => 'nuevo-articulo',
                 'content' => 'Contenido del articulo'
             ]
         ]
     ]);
     $response->assertJsonValidationErrors('data.attributes.title');
     
 }
//test ara que el titulo tenga al menos 4 caracteres:
/** @test **/
public function title_must_have_at_least_4_characters()
{
    //
    //$this->withoutExceptionHandling();
    $response = $this->postJson(route('api.v1.articles.create'), [
        'data' => [
            'type' => 'articles',
            'attributes' => [
                'title' => 'TRE', //enviamos titulo con 3 caracteres para que salte el error
                'slug' => 'nuevo-articulo',
                'content' => 'Contenido del articulo'
            ]
        ]
        //])->dump(); para imprimir respuesta
    ])/*->dump()   para imprimir respuesta json*/;
    $response->assertJsonValidationErrors('data.attributes.title');
    
}
  /** @test **/
  public function slug_is_required()
  {
      //
      //$this->withoutExceptionHandling();
      $response = $this->postJson(route('api.v1.articles.create'), [
          'data' => [
              'type' => 'articles',
              'attributes' => [
                  
                  'title' => 'Nuevo Articulo',
                  'content' => 'Contenido del articulo'
              ]
          ]
      ]);
      $response->assertJsonValidationErrors('data.attributes.slug');
      
  }
  /** @test **/
  public function content_is_required()
  {
      //
      //$this->withoutExceptionHandling();
      $response = $this->postJson(route('api.v1.articles.create'), [
          'data' => [
              'type' => 'articles',
              'attributes' => [
                  
                  'title' => 'Nuevo Articulo',
                  'slug' => 'nuevo-articulo'
              ]
          ]
      ]);
      //esperamos el error de validacion en el campo content
      $response->assertJsonValidationErrors('data.attributes.content');
      
  }


}
