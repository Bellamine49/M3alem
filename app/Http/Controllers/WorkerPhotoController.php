<?php

namespace App\Http\Controllers;

use App\Models\WorkerPhoto;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerPhotoController extends Controller
{
    public function store(Request $request, WorkerProfile $worker)
    {
        if (Auth::user()->workerProfile?->id !== $worker->id) {
            abort(403);
        }

        $request->validate([
            'photo' => 'required|image|max:10240',
            'caption' => 'nullable|string|max:500',
            'is_primary' => 'nullable|boolean',
        ]);

        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/worker-photos'), $filename);
        $path = 'uploads/worker-photos/' . $filename;

        if ($request->boolean('is_primary')) {
            $worker->photos()->update(['is_primary' => false]);
        }

        $worker->photos()->create([
            'photo_path' => $path,
            'caption' => $request->caption,
            'is_primary' => $request->boolean('is_primary'),
        ]);

        return back()->with('success', 'Photo added!');
    }

    public function destroy(WorkerPhoto $photo)
    {
        $worker = $photo->workerProfile;
        if (Auth::user()->workerProfile?->id !== $worker->id) {
            abort(403);
        }

        $fullPath = public_path($photo->photo_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        $photo->delete();

        return back()->with('success', 'Photo removed.');
    }

    public function setPrimary(WorkerPhoto $photo)
    {
        $worker = $photo->workerProfile;
        if (Auth::user()->workerProfile?->id !== $worker->id) {
            abort(403);
        }

        $worker->photos()->update(['is_primary' => false]);
        $photo->update(['is_primary' => true]);

        return back()->with('success', 'Primary photo updated.');
    }
}
