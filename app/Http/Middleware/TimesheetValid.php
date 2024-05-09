<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Timesheet;
use Symfony\Component\HttpFoundation\Response;

class TimesheetValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route('timesheet')) {
            // dd(1);
            if (Timesheet::find($request->route('timesheet'))) {
                return $next($request);
            }
            return redirect()->back()->with('error', 'Invalid id');
        }
        // dd(2);
        return $next($request);
    }
}
