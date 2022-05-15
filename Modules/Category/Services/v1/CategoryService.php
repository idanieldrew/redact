<?php

namespace Module\Category\Services\v1;

use Module\Category\Http\Resources\v1\CategoryResource;
use Module\Category\Services\CategoryService as Service;

class CategoryService extends Service
{
    /**
     * Create new category
     * @param \Module\Category\Http\Requests\v1\CategoryRequest $request
     * @return \Module\Category\Http\Resources\v1\CategoryResource
     */
    public function store($request)
    {
        $post =  auth()->user()->categories()->create([
            'name' => $request->name
        ]);

        return new CategoryResource($post);
    }
}