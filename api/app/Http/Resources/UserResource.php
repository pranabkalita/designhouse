<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
          'name' => $this->name,
          'email' => $this->email,
          'designs' => $this->designs,
          'dates' => [
            'created_at_human' => $this->created_at->diffForHumans(),
            'created_at' => $this->created_at,
            'updated_at_human' => $this->updated_at->diffForHumans(),
            'updated_at' => $this->updated_at,
          ]
        ];
    }
}
