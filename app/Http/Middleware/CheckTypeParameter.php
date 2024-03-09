<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckTypeParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->get('type')) {
            return redirect()->route('dashboard.finances.index', [
                'type' => 'incomes',
                'from' => Carbon::today()->format('Y-m-d'),
                'to' => Carbon::today()->format('Y-m-d'),
            ]);
        }

        return $next($request);
    }
}
