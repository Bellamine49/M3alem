<?php

namespace App\Http\Controllers;

use App\Models\WorkerProfile;
use App\Models\Category;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkerProfile::with(['user', 'category'])->where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('category', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('city', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', "%{$request->city}%");
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_unit', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_unit', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'rating' => $query->orderBy('rating', 'desc'),
                'price_asc' => $query->orderBy('price_per_unit', 'asc'),
                'price_desc' => $query->orderBy('price_per_unit', 'desc'),
                'experience' => $query->orderBy('experience_years', 'desc'),
                default => $query->orderBy('rating', 'desc'),
            };
        } else {
            $query->orderBy('rating', 'desc');
        }

        $workers = $query->paginate(12);
        $categories = Category::all();
        $mapData = $workers->map(fn($w) => ['name' => $w->user->name, 'category' => $w->category->name, 'city' => $w->city, 'rating' => $w->rating, 'url' => route('workers.show', $w)])->values()->all();

        return view('workers.index', compact('workers', 'categories', 'mapData'));
    }

    public function show(WorkerProfile $worker)
    {
        $worker->load(['user', 'category', 'reviews.user', 'photos']);
        $relatedWorkers = WorkerProfile::where('category_id', $worker->category_id)
            ->where('id', '!=', $worker->id)
            ->with('user')
            ->limit(4)
            ->get();

        return view('workers.show', compact('worker', 'relatedWorkers'));
    }
}
