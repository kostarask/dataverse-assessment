<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginThrottleMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $maxAttempts = 5, $decayMinutes = 1): Response
    {
        $key = $request->ip();

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return response()->json(['errors' => ['message' => [ __('Too Many Attempts.') ]]], 429);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        return $next($request);
    }
}
