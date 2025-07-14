<?php

namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// class IsAdmin
// {
//     public function handle(Request $request, Closure $next): Response
//     {
//         if (auth()->check() && auth()->user()->role === 'admin') {
//             return $next($request);
//         }

//         abort(403, 'Unauthorized action.');
//     }
// }

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
} //after admin dashboard implement

