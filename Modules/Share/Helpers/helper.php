<?php

use Illuminate\Contracts\Routing\UrlGenerator;

if (!function_exists('url')) {
    /**
     * Generate an url for the application.
     *
     * @param string|null $path
     * @param mixed $parameters
     * @param bool|null $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function kurl(string $path = null, $parameters = [], bool $secure = null)
    {
        if (is_null($path)) {
            return app(UrlGenerator::class);
        }

        $lang = App::getLocale();
        $path = "$lang/$path";

        return app(UrlGenerator::class)->to($path, $parameters, $secure);
    }
}
