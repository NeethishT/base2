<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\CommonUtils;

class AccessControls
{
    use CommonUtils;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if(auth()->check()){
            $permissions = $this->permissionsCaching(auth()->user());
            if(!auth()->user()->hasRole('super-admin') && !in_array($permission, $permissions)){
                abort(401);
            }
        }
        return $next($request);
    }
}
