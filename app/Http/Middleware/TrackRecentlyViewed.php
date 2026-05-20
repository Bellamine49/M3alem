<?php

namespace App\Http\Middleware;

use App\Models\RecentlyViewed;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackRecentlyViewed
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && $request->routeIs('workers.show')) {
            $worker = $request->route('worker');
            if ($worker) {
                RecentlyViewed::updateOrCreate(
                    ['user_id' => Auth::id(), 'worker_profile_id' => $worker->id],
                    ['updated_at' => now()]
                );
            }
        }

        return $response;
    }
}
