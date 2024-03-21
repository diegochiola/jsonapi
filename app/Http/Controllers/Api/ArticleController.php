<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function show(Article $article){
        return response()->json([
            'data'=> [
                'type' => 'atricles',
                'id' => (string) $article->getRouteKey(), //se pasa a string el id
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => url('api/v1/articles/'. $article->getRouteKey())
                ]

            ]
        ]);
    }
}
