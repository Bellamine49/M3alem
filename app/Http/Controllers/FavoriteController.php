<?php

namespace App\Http\Controllers;

use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with(['user', 'category'])->paginate(12);
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(WorkerProfile $worker)
    {
        $user = Auth::user();
        $isFavorited = $user->favorites()->where('worker_profile_id', $worker->id)->exists();

        if ($isFavorited) {
            $user->favorites()->detach($worker->id);
            return back()->with('success', 'Removed from favorites');
        }

        $user->favorites()->attach($worker->id);
        return back()->with('success', 'Added to favorites');
    }
}
