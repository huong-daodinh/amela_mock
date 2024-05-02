<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SortValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->input());
        $valid_columns = ['name', 'email', 'date_of_birth', 'department_id'];
        $valid_direction = ['asc', 'desc'];
        $col = $request->input('column');
        $direction = $request->input('direction');
        if (!in_array($col, $valid_columns) || !in_array($direction, $valid_direction)) {
            return redirect()->back()->with('error', 'Invalid column or direction');
        }
        return $next($request);
    }
}
