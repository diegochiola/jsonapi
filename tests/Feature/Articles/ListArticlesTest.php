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
        $response = $this->getJson('/api/v1/articles/' .$article->getRouteKey());
        $response->assertSee($article->title);

    }
}
