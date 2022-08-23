<?php

namespace Module\Post\Filters;

use Closure;

class BlueTick
{
    public function handle($request, Closure $next)
    {
        return $next($request)->where('blue_tick', request()->blue_tick);
    }
}
