<?php

namespace Module\Category\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\Category\Http\Resources\v1\CategoryCollection;
use Module\Category\Models\Category;
use Module\Category\Repository\v1\CategoryRepository;

class CategoryController extends Controller
{
    // resolve \Module\Post\Repository\v1\PostRepository
    public function repo()
    {
        return resolve(CategoryRepository::class);
    }

    // resolve \Module\Post\Services\PostService
    public function service()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Module\Category\Http\Resources\v1\CategoryCollection
     */
    public function index()
    {
        $categories = $this->repo()->take(Category::query());

        return new CategoryCollection($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
