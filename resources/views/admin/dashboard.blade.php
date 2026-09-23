<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Bubbles & Drop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#edf4ff] min-h-screen">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-[#233f91] text-white flex flex-col">

            {{-- Logo / Brand --}}
            <div class="px-6 py-6 border-b border-blue-400/20">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-lg bg-white/15
                                flex items-center justify-center">

                        <span class="text-xl">◉</span>

                    </div>

                    <div>
                        <h1 class="font-bold text-lg">
                            Bubbles & Drop
                        </h1>

                        <p class="text-xs text-blue-200">
                            Laundry Shop
                        </p>
                    </div>

                </div>

            </div>


            {{-- Admin Account --}}
            <div class="px-4 pt-4">

                <div class="bg-white/10 rounded-lg px-4 py-3">

                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 rounded-full bg-white
                                    text-blue-800 flex items-center
                                    justify-center font-bold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                        <div>

                            <p class="text-sm font-semibold">
                                Admin Account
                            </p>

                            <p class="text-xs text-blue-200">
                                Admin Portal
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Navigation --}}
            <nav class="px-4 mt-6 flex-1">

                <p class="text-xs uppercase tracking-widest
                        text-blue-300 px-3 mb-3">
                    Modules
                </p>

                {{-- Dashboard --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-3
                        rounded-lg bg-white/15 text-white mb-2"
                >
                    <span>▥</span>

                    <span class="text-sm font-medium">
                        Dashboard
                    </span>
                </a>

                {{-- Manage Inventory --}}
                <a
                    href="{{ route('admin.inventory.index') }}"
                    class="flex items-center gap-3 px-3 py-3
                        rounded-lg text-blue-100
                        hover:bg-white/10 transition"
                >
                    <span>▣</span>

                    <span class="text-sm">
                        Manage Inventory
                    </span>
                </a>

                {{-- Monitor Stock Levels --}}
                <a
                    href="{{ route('admin.inventory.monitor') }}"
                    class="flex items-center gap-3 px-3 py-3
                        rounded-lg text-blue-100
                        hover:bg-white/10 transition"
                >
                    <span>⌁</span>

                    <span class="text-sm">
                        Monitor Stock Levels
                    </span>
                </a>

                {{-- Record Stock-In --}}
                <a
                    href="{{ route('admin.inventory.stock-in') }}"
                    class="flex items-center gap-3 px-3 py-3
                        rounded-lg text-blue-100
                        hover:bg-white/10 transition"
                >
                    <span>↓</span>

                    <span class="text-sm">
                        Record Stock-In
                    </span>
                </a>

                {{-- Record Stock-Out --}}
                <a
                    href="{{ route('admin.inventory.stock-out') }}"
                    class="flex items-center gap-3 px-3 py-3
                        rounded-lg text-blue-100
                        hover:bg-white/10 transition"
                >
                    <span>↑</span>

                    <span class="text-sm">
                        Record Stock-Out
                    </span>
                </a>

                {{-- View Inventory --}}
                <a
                    href="{{ route('admin.inventory.view') }}"
                    class="flex items-center gap-3 px-3 py-3
                        rounded-lg text-blue-100
                        hover:bg-white/10 transition"
                >
                    <span>◉</span>

                    <span class="text-sm">
                        View Inventory
                    </span>
                </a>

            </nav>


            {{-- Logout --}}
            <div class="px-4 py-5 border-t border-blue-400/20">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-3
                               px-3 py-3 rounded-lg
                               text-blue-100 hover:bg-white/10"
                    >
                        <span>↪</span>

                        <span class="text-sm">
                            Sign Out
                        </span>
                    </button>

                </form>

            </div>

        </aside>


        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8 overflow-auto">

            {{-- Header --}}
            <div class="mb-7">

                <h1 class="text-3xl font-bold text-[#183984]">
                    Admin Dashboard
                </h1>

                <p class="text-sm text-blue-500 mt-1">
                    Good day! Here's the current inventory overview.
                </p>

            </div>


            {{-- SUMMARY CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2
                        xl:grid-cols-4 gap-5 mb-6">


                {{-- Total Items --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm
                            border border-blue-100">

                    <div class="flex items-center gap-4">

                        <div class="w-11 h-11 rounded-xl bg-blue-50
                                    flex items-center justify-center
                                    text-blue-700 text-xl">
                            ◇
                        </div>

                        <div>
                            <p class="text-sm text-blue-500">
                                Total Items
                            </p>

                            <p class="text-2xl font-bold text-blue-900">
                                {{ $totalItems }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Low Stock --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm
                            border border-red-100">

                    <div class="flex items-center gap-4">

                        <div class="w-11 h-11 rounded-xl bg-red-50
                                    flex items-center justify-center
                                    text-red-500 text-xl">
                            ⚠
                        </div>

                        <div>
                            <p class="text-sm text-blue-500">
                                Low Stock Alerts
                            </p>

                            <p class="text-2xl font-bold text-blue-900">
                                {{ $lowStockCount }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Stock In --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm
                            border border-green-100">

                    <div class="flex items-center gap-4">

                        <div class="w-11 h-11 rounded-xl bg-green-50
                                    flex items-center justify-center
                                    text-green-600 text-xl">
                            ↗
                        </div>

                        <div>
                            <p class="text-sm text-blue-500">
                                Stock-In Today
                            </p>

                            <p class="text-2xl font-bold text-blue-900">
                                {{ $stockInToday }}
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Stock Out --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm
                            border border-yellow-100">

                    <div class="flex items-center gap-4">

                        <div class="w-11 h-11 rounded-xl bg-yellow-50
                                    flex items-center justify-center
                                    text-yellow-600 text-xl">
                            ↘
                        </div>

                        <div>
                            <p class="text-sm text-blue-500">
                                Stock-Out Today
                            </p>

                            <p class="text-2xl font-bold text-blue-900">
                                {{ $stockOutToday }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- LOW STOCK ALERT --}}
            <div class="bg-red-50 border border-red-100
                        rounded-2xl p-5 mb-6">

                <div class="flex items-center gap-2 mb-4">

                    <span class="text-red-500">
                        ⚠
                    </span>

                    <h2 class="font-semibold text-red-700">
                        Low Stock Alert —
                        {{ $lowStockCount }} item(s) need attention
                    </h2>

                </div>


                @if ($lowStockItems->count())

                    <div class="flex flex-wrap gap-2">

                        @foreach ($lowStockItems as $item)

                            <span class="px-3 py-2 bg-white
                                         border border-red-200
                                         text-red-700 rounded-full
                                         text-sm">

                                {{ $item->item_name }}

                            </span>

                        @endforeach

                    </div>

                @else

                    <p class="text-sm text-green-700">
                        No low-stock items at the moment.
                    </p>

                @endif

            </div>


            {{-- RECENT STOCK IN --}}
            <div class="bg-white rounded-2xl border
                        border-blue-100 shadow-sm mb-6">

                <div class="px-5 py-4 border-b
                            border-gray-100 flex justify-between">

                    <h2 class="font-semibold text-blue-800">
                        ↓ Recent Stock-In
                    </h2>

                    <span class="text-sm text-blue-600">
                        Recent
                    </span>

                </div>


                @forelse ($recentStockIns as $transaction)

                    <div class="px-5 py-4 border-b
                                border-gray-100 last:border-0
                                flex justify-between items-center">

                        <div>

                            <p class="font-medium text-blue-800">
                                {{ $transaction->inventoryItem->item_name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $transaction->supplier ?? 'No supplier' }}
                                ·
                                {{ $transaction->date->format('Y-m-d') }}
                            </p>

                        </div>

                        <span class="font-bold text-green-600">
                            +{{ $transaction->quantity }}
                        </span>

                    </div>

                @empty

                    <div class="px-5 py-8 text-center
                                text-gray-500 text-sm">

                        No Stock-In records yet.

                    </div>

                @endforelse

            </div>


            {{-- RECENT STOCK OUT --}}
            <div class="bg-white rounded-2xl border
                        border-blue-100 shadow-sm mb-6">

                <div class="px-5 py-4 border-b
                            border-gray-100">

                    <h2 class="font-semibold text-blue-800">
                        ↑ Recent Stock-Out
                    </h2>

                </div>


                @forelse ($recentStockOuts as $transaction)

                    <div class="px-5 py-4 border-b
                                border-gray-100 last:border-0
                                flex justify-between items-center">

                        <div>

                            <p class="font-medium text-blue-800">
                                {{ $transaction->inventoryItem->item_name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $transaction->reason ?? 'No reason specified' }}
                                ·
                                {{ $transaction->date->format('Y-m-d') }}
                            </p>

                        </div>

                        <span class="font-bold text-red-500">
                            -{{ $transaction->quantity }}
                        </span>

                    </div>

                @empty

                    <div class="px-5 py-8 text-center
                                text-gray-500 text-sm">

                        No Stock-Out records yet.

                    </div>

                @endforelse

            </div>


            {{-- SHORTCUTS --}}
            <div class="grid grid-cols-1 md:grid-cols-2
                        xl:grid-cols-3 gap-4">

                @foreach ([
                    'Manage Inventory',
                    'Monitor Stock Levels',
                    'Record Stock-In',
                    'Record Stock-Out',
                    'View Inventory',
                ] as $module)

                    <a
                        href="#"
                        class="bg-white rounded-2xl border
                               border-blue-100 p-5 shadow-sm
                               hover:shadow-md transition"
                    >

                        <p class="text-sm font-semibold text-blue-800">
                            {{ $module }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            Open module
                        </p>

                    </a>

                @endforeach

            </div>

        </main>

    </div>

</body>
</html>