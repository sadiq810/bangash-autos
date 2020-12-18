<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Support\Facades\Route;

class RolesMenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menus = auth()->user()->role->menus;
        $currentRouteName = Route::currentRouteName();
        $routeExist = Menu::where('route', $currentRouteName)->first();
        if ($routeExist && !$menus->contains('route', $currentRouteName))
            abort(403);

        return $next($request);
    }
}
