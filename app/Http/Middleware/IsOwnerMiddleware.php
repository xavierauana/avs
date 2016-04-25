<?php

namespace App\Http\Middleware;

use App\Property;
use Closure;

class IsOwnerMiddleware
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

        if(!$request->route('propertyId') or $request->user() == Property::findOrFail($request->route('propertyId'))->owner) return $next($request);

        abort(403,"You don't have the permission for the request!");
    }
}
