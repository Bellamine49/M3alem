@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Profile Settings</h1>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Account Information</h2>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
            </div>
            <button type="submit" class="mt-6 bg-gray-900 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-gray-800 transition-colors">Save Changes</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Worker Profile</h2>
                <p class="text-gray-500 text-sm mt-1">Set up your service details so clients can find you</p>
            </div>
            @if($workerProfile)
            <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 text-sm font-medium rounded-full">
                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>Active
            </span>
            @endif
        </div>
        <form method="POST" action="{{ route('profile.worker.update') }}">
            @csrf @method('PATCH')
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Category *</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 appearance-none cursor-pointer">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $workerProfile?->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $workerProfile?->phone) }}" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="+212 6XX XXX XXX">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" name="city" value="{{ old('city', $workerProfile?->city) }}" 
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Experience (years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $workerProfile?->experience_years ?? 0) }}" min="0"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                    <input type="number" name="price_per_unit" value="{{ old('price_per_unit', $workerProfile?->price_per_unit) }}" step="0.01" min="0" required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Unit *</label>
                    <select name="price_unit" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 appearance-none cursor-pointer">
                        <option value="per_hour" {{ old('price_unit', $workerProfile?->price_unit) == 'per_hour' ? 'selected' : '' }}>Per Hour</option>
                        <option value="per_day" {{ old('price_unit', $workerProfile?->price_unit) == 'per_day' ? 'selected' : '' }}>Per Day</option>
                        <option value="per_square_meter" {{ old('price_unit', $workerProfile?->price_unit) == 'per_square_meter' ? 'selected' : '' }}>Per m²</option>
                        <option value="per_project" {{ old('price_unit', $workerProfile?->price_unit) == 'per_project' ? 'selected' : '' }}>Per Project</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio / Description</label>
                    <textarea name="bio" rows="3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" placeholder="Describe your experience, skills, and what makes you stand out...">{{ old('bio', $workerProfile?->bio) }}</textarea>
                </div>
            </div>
            <button type="submit" class="mt-6 bg-gradient-to-r from-brand-600 to-brand-700 text-white px-8 py-2.5 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all">
                Save Worker Profile
            </button>
        </form>
    </div>

    @if($workerProfile)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Work Photos</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            @forelse($workerProfile->photos as $photo)
            <div class="relative group rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                <img src="{{ $photo->url }}" alt="{{ $photo->caption ?? 'Photo' }}" class="w-full h-32 object-cover">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                    <form action="{{ route('worker.photos.primary', $photo) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="bg-white text-gray-900 text-xs px-2 py-1 rounded-lg font-medium shadow {{ $photo->is_primary ? 'ring-2 ring-brand-500' : '' }}"><i class="fas fa-star mr-1"></i>{{ $photo->is_primary ? 'Primary' : 'Set' }}</button>
                    </form>
                    <form action="{{ route('worker.photos.destroy', $photo) }}" method="POST" class="inline" onsubmit="return confirm('Remove this photo?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white text-xs px-2 py-1 rounded-lg font-medium"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                @if($photo->is_primary)
                <span class="absolute top-1 left-1 bg-brand-600 text-white text-[10px] px-1.5 py-0.5 rounded font-medium">Primary</span>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-400">
                <i class="fas fa-camera text-2xl mb-2"></i>
                <p class="text-sm">No photos yet. Upload your work samples!</p>
            </div>
            @endforelse
        </div>
        <form action="{{ route('worker.photos.store', $workerProfile) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Add Photo</label>
                <input type="file" name="photo" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
            </div>
            <div class="w-40">
                <input type="text" name="caption" placeholder="Caption (optional)" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600 whitespace-nowrap">
                <input type="checkbox" name="is_primary" value="1"> Primary
            </label>
            <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-brand-700"><i class="fas fa-upload mr-1"></i>Upload</button>
        </form>
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Change Password</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
                <div></div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                </div>
            </div>
            <button type="submit" class="mt-6 bg-gray-900 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-gray-800 transition-colors">Update Password</button>
        </form>
    </div>
</div>
@endsection
