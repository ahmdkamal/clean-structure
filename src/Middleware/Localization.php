<?php

namespace Kamal\CleanStructure\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locales = file_exists(config_path('clean-code.php'))
            ? config('clean-code.locales')
            : json_decode(file_get_contents(base_path( __DIR__.'clean-code.php')), true);

        $lang = $request->header('Accept-Language') && in_array($request->header('Accept-Language'), $locales)
            ? $request->header('Accept-Language') : config('clean-code.default_lang');

        app()->setlocale($lang);

        return $next($request);
    }
}
