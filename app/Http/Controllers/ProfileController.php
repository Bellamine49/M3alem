<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use App\Models\WorkerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $categories = Category::all();
        $workerProfile = $request->user()->workerProfile;

        return view('profile.edit', [
            'user' => $request->user(),
            'categories' => $categories,
            'workerProfile' => $workerProfile,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateWorkerProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'price_per_unit' => 'required|numeric|min:0',
            'price_unit' => 'required|in:per_hour,per_day,per_square_meter,per_project',
            'city' => 'nullable|string|max:100',
            'experience_years' => 'required|integer|min:0',
        ]);

        $user = $request->user();

        if ($user->role !== 'worker') {
            $user->update(['role' => 'worker']);
        }

        WorkerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'category_id' => $request->category_id,
                'phone' => $request->phone,
                'bio' => $request->bio,
                'price_per_unit' => $request->price_per_unit,
                'price_unit' => $request->price_unit,
                'city' => $request->city,
                'experience_years' => $request->experience_years,
            ]
        );

        return Redirect::route('profile.edit')->with('success', 'Worker profile updated!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
