<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleTache
{
    public function handle(Request $request, Closure $next, $tache, $action = 'can_view')
    {
        $user = Auth::user();

        if (!$user || !$user->taches()->where('tache_id', $tache)->where($action, true)->exists()) {
            abort(403, 'Accès interdit');
        }

        return $next($request);
    }
}
