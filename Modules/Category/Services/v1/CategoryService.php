<?php

namespace Module\Category\Services\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Module\Category\Http\Requests\v1\StoreRequest as StoreRequestAlias;
use Module\Category\Http\Resources\v1\CategoryResource;
use Module\Category\Models\Category;
use Module\Category\Services\CategoryService as Service;

class CategoryService extends Service
{
    /**
     * Create new category
     * @param StoreRequestAlias $request
     * @return \Module\Category\Http\Resources\v1\CategoryResource
     */
    public function store(StoreRequestAlias $request): CategoryResource
    {
        //  just admin & super can store new category
        if (Gate::denies('createOrUpdate', [Category::class])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        // Store category
        $post = auth()->user()->categories()->create([
            'name' => [
                'en' => $request->name['en'],
                'fa' => $request->name['fa']
            ],
        ]);

        return new CategoryResource($post);
    }

    /**
     * Update category
     * @param string $category
     * @param \Module\User\Http\Requests\v1\UserRequest; $request
     * @return null
     */
    public function update($category, $request)
    {
        // Just user can edit our information
        if (Gate::denies('createOrUpdate', [Category::class])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $category->update([
            'name' => $request->name
        ]);
    }
}
