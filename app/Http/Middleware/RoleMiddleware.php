<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $Request, Closure $Next, string $Role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $Role) {
            $UserRole = auth()->user()->role;
            return redirect('/' . ucfirst($UserRole) . '/Dashboard');
        }

        if ($Role === 'hospital' && auth()->user()->status !== 'approved') {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your hospital account is pending admin approval.');
        }

        return $Next($Request);
    }
}
