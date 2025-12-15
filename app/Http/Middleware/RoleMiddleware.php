<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'No autenticado');
        }

        // Log para depurar el rol del usuario
        Log::info('RoleMiddleware - User role:', ['role' => $user->role]);

        // Verificar si el rol del usuario está en los roles permitidos
        if (!in_array($user->role, $roles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
