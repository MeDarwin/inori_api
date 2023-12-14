<?php

namespace App\Http\Middleware;

use App\Models\Division;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClubLeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Division::query()->where('division_lead', auth()->user()->username)->first('division_lead') === null) {
            return response()->json(['message' => "You are forbidden to perform this action"], 403);
        }
        return $next($request);
    }
}
