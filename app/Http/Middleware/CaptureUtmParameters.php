<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;


class CaptureUtmParameters
{
    function handle($request, Closure $next)
    {
        if ($request->has('utm_source')) {
            session([
                'utm_source' => $request->get('utm_source'),
                'utm_medium' => $request->get('utm_medium'),
                'utm_campaign' => $request->get('utm_campaign')
            ]);
        }
        return $next($request);
    }
}
