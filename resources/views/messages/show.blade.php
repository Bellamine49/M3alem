@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-4">
        <a href="{{ route('messages.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors group">
            <i class="fas fa-arrow-left mr-2 text-xs group-hover:-translate-x-1 transition-transform"></i>Back to messages
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-[75vh]">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center">
                <div class="w-11 h-11 bg-gradient-to-br from-brand-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                    @if(auth()->id() === $conversation->client_id)
                        {{ substr($conversation->workerProfile->user->name, 0, 1) }}
                    @else
                        {{ substr($conversation->client->name, 0, 1) }}
                    @endif
                </div>
                <div class="ml-3">
                    <h3 class="font-semibold text-gray-900">
                        @if(auth()->id() === $conversation->client_id)
                            {{ $conversation->workerProfile->user->name }}
                        @else
                            {{ $conversation->client->name }}
                        @endif
                    </h3>
                    <p class="text-xs text-gray-500">
                        @if(auth()->id() === $conversation->client_id)
                            {{ $conversation->workerProfile->category->name }}
                        @else
                            Client
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-1">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-xs text-emerald-600 font-medium">Online</span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-3" id="chat-messages" x-data="{ messages: @json($messagesJson) }">
            @php $lastDate = null; @endphp
            @foreach($messages as $msg)
                @php $msgDate = $msg->created_at->format('Y-m-d'); @endphp
                @if($msgDate !== $lastDate)
                    <div class="flex justify-center my-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-medium rounded-full">{{ $msg->created_at->format('M j, Y') }}</span>
                    </div>
                    @php $lastDate = $msgDate; @endphp
                @endif
                <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} items-end space-x-2 group">
                    @if($msg->sender_id !== auth()->id())
                        <div class="w-7 h-7 bg-gradient-to-br from-brand-500 to-purple-500 rounded-full flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                            @if(auth()->id() === $conversation->client_id)
                                {{ substr($conversation->workerProfile->user->name, 0, 1) }}
                            @else
                                {{ substr($conversation->client->name, 0, 1) }}
                            @endif
                        </div>
                    @endif
                    <div class="max-w-[75%] {{ $msg->sender_id === auth()->id() ? 'bg-brand-600 text-white rounded-2xl rounded-br-sm' : 'bg-gray-100 text-gray-900 rounded-2xl rounded-bl-sm' }} px-4 py-2.5 shadow-sm">
                        <p class="text-sm leading-relaxed">{{ $msg->body }}</p>
                        <p class="text-xs {{ $msg->sender_id === auth()->id() ? 'text-brand-200' : 'text-gray-400' }} mt-0.5 text-right flex items-center justify-end space-x-1">
                            <span>{{ $msg->created_at->format('H:i') }}</span>
                            @if($msg->sender_id === auth()->id())
                                <i class="fas fa-check text-[10px] {{ $msg->is_read ? 'text-blue-300' : 'text-brand-200' }}"></i>
                            @endif
                        </p>
                    </div>
                    @if($msg->sender_id === auth()->id())
                        <div class="w-7 h-7 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    @endif
                </div>
            @endforeach
        </div>

        @if($errors->any())
        <div class="px-6 py-3 bg-red-50 border-t border-red-100 flex-shrink-0">
            @foreach($errors->all() as $error)
            <p class="text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="px-4 py-3 border-t border-gray-100 bg-white flex-shrink-0">
            <form method="POST" action="{{ route('messages.store', $conversation) }}" class="flex items-center space-x-2">
                @csrf
                <div class="flex-1 relative">
                    <input type="text" name="body" placeholder="Type a message..." required maxlength="2000" autocomplete="off"
                           class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-full focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all text-sm">
                </div>
                <button type="submit" class="w-11 h-11 bg-gradient-to-r from-brand-600 to-brand-700 rounded-full flex items-center justify-center text-white hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all hover:scale-105 active:scale-95 flex-shrink-0">
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const chat = document.getElementById('chat-messages');
    chat.scrollTop = chat.scrollHeight;
</script>
@endsection
