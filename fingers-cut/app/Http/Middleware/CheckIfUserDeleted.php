<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfUserDeleted
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->name === 'Utilisateur supprimé') {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Ce compte a été anonymisé et ne peut plus se connecter.']);
        }

        return $next($request);
    }
}
