<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function show(Article $article): ArticleResource{
        return ArticleResource::make($article);
    }
    public function index(){
        $articles = Article::all(); //queda pendiente paginarlos
        //como necesitamos una coleccion de articleResources
        return ArticleCollection::make(Article::all()); //cada uno de los articulos se envuela

    }

}
