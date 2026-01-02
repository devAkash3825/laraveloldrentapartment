<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission
{
    /**
     *
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, $permissionField)
    {
        
        $user = Auth::guard('admin')->user();
        if ($user && $user->$permissionField === '1') {
            return $next($request);
        }else{
            return abort(403, 'Unauthorized action.');
        }
        
    }
}
