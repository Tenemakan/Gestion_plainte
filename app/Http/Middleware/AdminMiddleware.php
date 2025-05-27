<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Vérifie si l'utilisateur est connecté et a le rôle d'administrateur
        if (!(Auth::check() && Auth::user()->role == 'admin')) {
            return redirect('/users')->with('error', 'Vous n\'avez pas les droits d\'accès à cette page.');
        }
        
        return $next($request);
    }
}
