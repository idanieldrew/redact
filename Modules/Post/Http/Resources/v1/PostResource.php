<?php

namespace Module\Post\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Tag\Http\Resources\v1\TagCollection;
use Module\Tag\Http\Resources\v1\TagResource;
use Module\User\Http\Resources\v1\UserResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'details' => $this->details,
            'description' => $this->description,
            'banner' => $this->banner,
//          'user' => UserResource::collection($this->whenLoaded('user')),
            'user' => new UserResource($this->user),
            'tags' => new TagCollection($this->tags),
            'blue_tick' => $this->blue_tick,
            'created_at' => $this->created_at
        ];
    }
}
