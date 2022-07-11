<?php

namespace Module\Tag\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Module\Tag\Repository\v1\TagRepository;

class TagController extends Controller
{
    // resolve \Module\Post\Repository\v1\PostRepository
    public function repo()
    {
        return resolve(TagRepository::class);
    }

    public function index()
    {
        return $this->repo()->paginate(15);
    }
}
