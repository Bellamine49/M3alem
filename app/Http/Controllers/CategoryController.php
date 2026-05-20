<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('workerProfiles')->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $workers = $category->workerProfiles()
            ->with('user')
            ->orderBy('rating', 'desc')
            ->paginate(12);
        return view('categories.show', compact('category', 'workers'));
    }
}
