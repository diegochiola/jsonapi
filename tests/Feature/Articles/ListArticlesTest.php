<?php

namespace Tests\Feature\Articles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;
 /** @test **/
    public function can_fetch_a_single_article(): void
    {
        $this->withoutExceptionHandling(); //excepciones de errores
        $article = Article::factory()->create();
        $response = $this->getJson(route('api.v1.articles.show', $article));
        $response->assertExactJson([
            'data'=> [
                'type' => 'atricles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]

            ]
        ]);

    }

public function can_fetch_all_articles(){
    //primero crear articulos con factori
    $articles = Article::factory()->count(3)->create();
    $response = $this->getJson(route('api.v1.articles.index'));
    $response->assertExactJson([
        'data'=>[
            [
                'tupe'=> 'articles',
                'id' => (string) $articles[0]->getRouteKey(),
                'atributes' => [
                    'title' => $articles[0]->title,
                    'slug' => $articles[0]->slug,
                    'content' => $articles[0]->content,
                ],
                'links' =>[
                    'self' =>route('api.v1.articles.show', $articles[0])
                ]
            ],
            [
                'tupe'=> 'articles',
                'id' => (string) $articles[1]->getRouteKey(),
                'atributes' => [
                    'title' => $articles[1]->title,
                    'slug' => $articles[1]->slug,
                    'content' => $articles[1]->content,
                ],
                'links' =>[
                    'self' =>route('api.v1.articles.show', $articles[1])
                ]
            ],
            [
                'tupe'=> 'articles',
                'id' => (string) $articles[2]->getRouteKey(),
                'atributes' => [
                    'title' => $articles[2]->title,
                    'slug' => $articles[2]->slug,
                    'content' => $articles[2]->content,
                ],
                'links' =>[
                    'self' =>route('api.v1.articles.show', $articles[2])
                ]
            ]  
        ]
    ]);

}

}
