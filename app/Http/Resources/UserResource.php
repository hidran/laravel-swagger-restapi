<?php

namespace App\Http\Resources;

use Database\Seeders\PostSeeder;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostCollection;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
             'posts' => new PostCollection($this->whenLoaded('posts')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
