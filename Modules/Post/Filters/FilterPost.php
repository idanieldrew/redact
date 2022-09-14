<?php

namespace Module\Post\Filters;

use Closure;

class FilterPost
{
    public function handle($request, Closure $next)
    {
       /* dd(request()->keyword);
        return $next($request);*/
        return $next($request)->where('title', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('details', 'LIKE', '%' . request()->keyword . '%');
    }
}
