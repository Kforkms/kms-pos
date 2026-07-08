<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex items-center text-xs text-gray-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-pink-600 transition-colors">Home</a>
                    <svg class="w-3.5 h-3.5 mx-1.5 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-pink-600 font-semibold">Kitchen Display</span>
                </nav>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Kitchen Display System 🔥
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-bold text-green-700">LIVE</span>
                </div>
                <span class="text-sm text-gray-400">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </x-slot>

    {{-- Auto refresh setiap 30 detik --}}
    <meta http-equiv="refresh" content="30">

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($todayOrders->count() === 0)
        <div class="flex flex-col items-center justify-center py-24">
            <div class="w-24 h-24 bg-pink-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-pink-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-xl font-bold text-gray-400">Belum ada pesanan hari ini</p>
            <p class="text-sm text-gray-300 mt-1">Pesanan akan muncul otomatis di sini</p>
        </div>
    @else
        {{-- Order Stats Bar --}}
        <div class="grid grid-cols-1 md:grid-cols-4 w-full gap-4 mb-6">
            <div class="bg-white border border-pink-100 rounded-xl px-4 py-3 flex items-center gap-3 shadow-sm">
                <span class="text-3xl">📋</span>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Total Pesanan</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $todayOrders->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-orange-100 rounded-xl px-4 py-3 flex items-center gap-3 shadow-sm">
                <span class="text-3xl">🍛</span>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Dine In</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $todayOrders->where('order_type', 'dine_in')->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-blue-100 rounded-xl px-4 py-3 flex items-center gap-3 shadow-sm">
                <span class="text-3xl">🥡</span>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Takeaway</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $todayOrders->where('order_type', 'takeaway')->count() }}</p>
                </div>
            </div>
            <div class="bg-white border border-purple-100 rounded-xl px-4 py-3 flex items-center gap-3 shadow-sm">
                <span class="text-3xl">📱</span>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Online</p>
                    <p class="text-2xl font-extrabold text-gray-800">{{ $todayOrders->where('order_type', 'online')->count() }}</p>
                </div>
            </div>
        </div>

        {{-- Orders Grid (Kanban Style) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
            @foreach($todayOrders as $order)
                @php
                    $orderTypeConfig = match($order->order_type) {
                        'dine_in' => ['label' => 'DINE IN', 'emoji' => '🍽️'],
                        'takeaway' => ['label' => 'TAKEAWAY', 'emoji' => '🥡'],
                        'online' => ['label' => 'ONLINE', 'emoji' => '📱'],
                        default => ['label' => 'DINE IN', 'emoji' => '🍽️'],
                    };

                    $statusConfig = match($order->status) {
                        'pending' => ['bg' => 'bg-orange-500', 'border' => 'border-orange-500', 'badge' => 'bg-orange-100 text-orange-700'],
                        'preparing' => ['bg' => 'bg-blue-500', 'border' => 'border-blue-500', 'badge' => 'bg-blue-100 text-blue-700'],
                        default => ['bg' => 'bg-gray-500', 'border' => 'border-gray-400', 'badge' => 'bg-gray-100 text-gray-700'],
                    };

                    $minutesAgo = $order->created_at->diffInMinutes(now());
                    $isUrgent = $minutesAgo > 15 && $order->status === 'pending';
                @endphp

                <div class="bg-white rounded-2xl border-y border-r border-l-4 shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg flex flex-col h-full
                    {{ $isUrgent ? 'border-red-600 animate-pulse' : $statusConfig['border'] }} border-y-gray-100 border-r-gray-100">

                    {{-- Order Header --}}
                    <div class="{{ $statusConfig['bg'] }} px-4 py-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ $orderTypeConfig['emoji'] }}</span>
                            <div>
                                <p class="text-white font-extrabold text-sm tracking-wide">{{ $orderTypeConfig['label'] }}</p>
                                <p class="text-white/80 text-[10px] font-medium">{{ $order->invoice_number }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-bold text-xs">{{ $order->created_at->format('H:i') }}</p>
                            <p class="text-white/80 text-[10px] font-medium">{{ $minutesAgo }} menit lalu</p>
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <p class="text-xl font-extrabold text-gray-800 tracking-tight">
                            {{ $order->customer_name ?: 'Pelanggan' }}
                        </p>
                        <span class="text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-widest {{ $statusConfig['badge'] }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    {{-- Order Items --}}
                    <div class="px-4 py-3 flex-1 overflow-y-auto">
                        @foreach($order->transactionItems as $item)
                            @if($item->product && in_array($item->product->category, ['makanan', 'minuman']))
                                <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="text-lg">
                                            {{ $item->product->category === 'makanan' ? '🍛' : '🥤' }}
                                        </span>
                                        <span class="font-bold text-base text-gray-800">{{ $item->product->name }}</span>
                                    </div>
                                    <span class="bg-gray-100 text-gray-800 font-extrabold text-base px-3 py-1 rounded-full min-w-[40px] text-center border border-gray-200">
                                        x{{ $item->quantity }}
                                    </span>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Action Buttons --}}
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50 mt-auto">
                        @if($order->status === 'pending')
                            <form action="{{ route('kds.status.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl shadow-md transition-all hover:scale-[1.02]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Mulai Masak
                                </button>
                            </form>
                        @elseif($order->status === 'preparing')
                            <form action="{{ route('kds.status.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-md transition-all hover:scale-[1.02]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Selesai & Antar
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Urgent Warning --}}
                    @if($isUrgent)
                        <div class="bg-red-50 border-t border-red-200 px-4 py-2 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-bold text-red-600">URGENT — Tertunda {{ $minutesAgo }} menit!</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
