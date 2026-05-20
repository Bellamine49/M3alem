<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, WorkerProfile $worker)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'worker_profile_id' => $worker->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        $this->updateWorkerRating($worker);

        return back()->with('success', 'Review submitted successfully!');
    }

    private function updateWorkerRating(WorkerProfile $worker)
    {
        $avgRating = $worker->reviews()->avg('rating');
        $totalReviews = $worker->reviews()->count();

        $worker->update([
            'rating' => round($avgRating ?? 0, 2),
            'total_reviews' => $totalReviews,
        ]);
    }
}
