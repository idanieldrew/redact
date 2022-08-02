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
        $locale = $request->segment(2);
        // $locale = en or fa

        if (in_array($locale, config('app.locales'))) {
            App::setLocale($locale);
            return $next($request);
        }

        if (!in_array($locale, config('app.locales'))) {
            $oldSegments = $request->segments();
            // $oldSegments = ["api","nl","category",...]

            $oldSegments[1] = config('app.fallback_locale');
            // $oldSegments[1] != nl change to "en"

            $newSegments = Arr::except($oldSegments, ['0', '1']);
            // $newSegments = [2 => "category", 3 => ...]

            array_unshift($newSegments, $oldSegments[0], $oldSegments[1]);
            // $oldSegments = ["api","en","category",...]
            
            return redirect(implode('/', $newSegments));
        }
    }
}
