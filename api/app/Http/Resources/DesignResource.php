<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'user' => new UserResource($this->whenLoaded('user')),
        'title' => $this->title,
        'slug' => $this->slug,
        'description' => $this->description,
        'is_live' => $this->is_live,
        'likes_count' => $this->likes()->count(),
        'images' => $this->images,
        'tags_list' => [
          'tags' => $this->tagArray,
          'normalized' => $this->tagArrayNormalized,
        ],
        'comments' => CommentResource::collection($this->whenLoaded('comments')),
        'dates' => [
          'created_at_human' => $this->created_at->diffForHumans(),
          'created_at' => $this->created_at,
          'updated_at_human' => $this->updated_at->diffForHumans(),
          'updated_at' => $this->updated_at,
        ]
      ];
    }
}
