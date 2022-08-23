<?php

namespace Module\Post\Filters;

use Closure;

class Published
{
    public function handle($request, Closure $next)
    {
        return $next($request)->where('published', false);
    }
}
