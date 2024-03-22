<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function toArray(Request $request): array
    {
        // Devolvemos la estructura de un recurso article
        return [
            'type' => 'articles',
            'id' => (string) $this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->resource->title,
                'slug' => $this->resource->slug,
                'content' => $this->resource->content
            ],
            'links' => [
                'self' => route('api.v1.articles.show', $this->resource)
            ]
        ];
    }

    //sobreescribir metodo toResponse
    public function toResponse($request){
        //agregarle los header
        return parent::toResponse($request)->withHeaders([
            'Location' => route('api.v1.articles.show', $this->resource)
        ]);
    }
}
