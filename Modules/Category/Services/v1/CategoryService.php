<?php

namespace Module\Category\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Module\Category\Http\Resources\v1\CategoryResource;
use Module\Category\Models\Category;
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
        //  just admin & super can store new category
        if (Gate::denies('create',[Category::class])){
            abort(Response::HTTP_FORBIDDEN);
        }

        // Store category
        $post =  auth()->user()->categories()->create([
            'name' => $request->name
        ]);

        return new CategoryResource($post);
    }
}