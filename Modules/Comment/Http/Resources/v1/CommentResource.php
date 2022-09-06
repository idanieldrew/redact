<?php

namespace Module\Comment\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Module\Category\Http\Resources\v1\CategoryCollection;
use Module\Media\Http\Resources\v1\MediaCollection;
use Module\Tag\Http\Resources\v1\TagCollection;
use Module\User\Http\Resources\v1\UserResource;

class CommentResource extends JsonResource
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
            'body' => $this->body,
        ];
    }
}
