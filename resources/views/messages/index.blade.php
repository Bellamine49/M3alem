@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
            <p class="text-gray-500 text-sm mt-0.5">Your conversations</p>
        </div>
        <a href="{{ route('workers.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">
            <i class="fas fa-plus mr-1"></i>New Chat
        </a>
    </div>

    @if($conversations->isEmpty())
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-16 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-gray-50 to-brand-50 rounded-full flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-comment-dots text-brand-300 text-3xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No conversations yet</h3>
        <p class="text-gray-500 text-sm mb-6">Find a worker and send them a message to get started</p>
        <a href="{{ route('workers.index') }}" class="inline-flex items-center bg-gradient-to-r from-brand-600 to-brand-700 text-white px-6 py-2.5 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all hover:scale-105">
            <i class="fas fa-search mr-2"></i>Find Workers
        </a>
    </div>
    @else
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden divide-y divide-gray-50">
        @foreach($conversations as $conv)
        <a href="{{ route('messages.show', $conv) }}" class="flex items-center px-5 py-4 hover:bg-gray-50 transition-all group">
            <div class="relative flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-brand-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                    @if(auth()->user()->role === 'worker')
                        {{ substr($conv->client->name, 0, 1) }}
                    @else
                        {{ substr($conv->workerProfile->user->name, 0, 1) }}
                    @endif
                </div>
                <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
            </div>
            <div class="ml-4 flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 truncate text-sm">
                        @if(auth()->user()->role === 'worker')
                            {{ $conv->client->name }}
                        @else
                            {{ $conv->workerProfile->user->name }}
                        @endif
                    </h3>
                    @if($conv->last_message_at)
                    <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $conv->last_message_at->diffForHumans() }}</span>
                    @endif
                </div>
                @if($conv->lastMessage)
                <p class="text-sm text-gray-500 truncate mt-0.5">{{ $conv->lastMessage->body }}</p>
                @endif
            </div>
            <i class="fas fa-chevron-right text-gray-200 ml-4 text-xs group-hover:text-gray-400 transition-colors"></i>
        </a>
        @endforeach
    </div>
    @endif
</div>
@endsection
