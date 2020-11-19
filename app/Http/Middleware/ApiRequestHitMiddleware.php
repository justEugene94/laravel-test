<?php

namespace App\Http\Middleware;

use App\Events\ApiRequestHit;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiRequestHitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        event(new ApiRequestHit($user));

        return $next($request);
    }
}
