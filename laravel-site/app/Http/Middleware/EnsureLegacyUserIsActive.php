<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLegacyUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && method_exists($request->user(), 'isActive') && ! $request->user()->isActive()) {
            auth()->logout();

            return redirect()->route('login')->withErrors([
                'login' => 'Usuário inativo.',
            ]);
        }

        return $next($request);
    }
}
