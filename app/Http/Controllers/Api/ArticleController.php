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
    public function index(): ArticleCollection{
        //$articles = Article::all(); //queda pendiente paginarlos
        //como necesitamos una coleccion de articleResources
        return ArticleCollection::make(Article::all()); //cada uno de los articulos se envuela

    }
    public function create(Request $request){
        //validación:
        $request->validate([
            'data.attributes.title' => ['required', 'min:4'],//agregamos que debe tener 4 caracteres
            'data.attributes.slug' => ['required'],
            'data.attributes.content' => ['required']
        ]);

        $article = Article::create([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),
        ]);
        return ArticleResource::make($article);
        
    }

}
