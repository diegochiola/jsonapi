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
        //devolvemos la estructura de un recurso article
        return [ //se quita el data porque le laravel resource lo encierra en data automaticamente
            
                'type' => 'atricles',
                'id' => (string) $this->resource->getRouteKey(), //se pasa a string el id
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
}
