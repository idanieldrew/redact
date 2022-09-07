<?php

namespace Module\Post\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Category\Http\Resources\v1\CategoryCollection;
use Module\Comment\Http\Resources\v1\CommentCollection;
use Module\Media\Http\Resources\v1\MediaCollection;
use Module\Tag\Http\Resources\v1\TagCollection;
use Module\User\Http\Resources\v1\UserResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
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
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
            'tags' => $this->whenLoaded('tags', function () {
                return new TagCollection($this->tags);
            }),
            'media' => $this->whenLoaded('media', function () {
                return new MediaCollection($this->media);
            }),
            'categories' => $this->whenLoaded('categories', function () {
                return new CategoryCollection($this->categories);
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return new CommentCollection($this->comments);
            }),
            'blue_tick' => $this->blue_tick,
            'published' => $this->published,
            'created_at' => $this->created_at
        ];
    }
}
