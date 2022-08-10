<?php

namespace Module\Lang\Http\Middleware;

use App;
use Arr;
use Closure;
use Illuminate\Http\Request;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $req = $request->segments();

        $locale = $request->segment(2);

        if (in_array($locale, config('app.locales'))) {
            App::setLocale($locale);
            return $next($request);

        } else {
            $lang = config('app.fallback_locale');
            $uri = array_replace($req, [$lang]);

            return 'api/' . redirect(implode('/', $uri));
        }
    }
}
