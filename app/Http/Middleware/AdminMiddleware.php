<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Gate;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Gate::allows('is-admin')){
            return $next($request);
        }
        return redirect('/')->with('error', 'Accès refusé. Vous devez être un administrateur');
    }
}
