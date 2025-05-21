<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackPageViews
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() === 'GET' && !$request->is('admin/*')) {
            DB::table('page_views')->insert([
                'url' => $request->path(),
                'ip' => $request->ip(),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $next($request);
    }
}