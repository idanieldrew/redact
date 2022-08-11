<?php

namespace Module\Category\Observers;

use Illuminate\Support\Str;
use Module\Category\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param \Module\Category\Models\Category $category
     * @return void
     * @throws \Exception
     */
    public function creating(Category $category)
    {
        $category->slug = Str::slug($category->getTranslation('name', 'en'));
    }

    /**
     * Handle the Post "updating" event.
     *
     * @param \Module\Category\Models\Category $category
     * @return void
     */
    public function updating(Category $category)
    {
        $category->slug = Str::slug($category->name);
    }
}
