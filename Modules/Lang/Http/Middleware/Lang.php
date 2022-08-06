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
        /*$req = $request->segments();

        $locale = $request->segment(2);
        if (count($req) <= 2) {
            return redirect()->route('post.index');
        }

        if (in_array($locale, config('app.locales'))) {
            App::setLocale($locale);
            return $next($request);
        } elseif (!in_array($locale, config('app.locales'))) {
            $oldSegments = $request->segments();
            $oldSegments[1] = config('app.fallback_locale');
            return redirect(implode('/', $oldSegments));
        } else {
            return redirect()->route('post.index');
        }*/
    }
}
