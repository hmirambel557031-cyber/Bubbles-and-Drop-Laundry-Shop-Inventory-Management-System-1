<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>View Inventory - Bubbles & Drop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#edf4ff] min-h-screen">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-[#233f91] text-white flex flex-col">

        <div class="px-6 py-6 border-b border-blue-400/20">

            <h1 class="font-bold text-lg">
                Bubbles & Drop
            </h1>

            <p class="text-xs text-blue-200">
                Laundry Shop
            </p>

        </div>


        <div class="px-4 pt-4">

            <div class="bg-white/10 rounded-lg px-4 py-3">

                <p class="text-sm font-semibold">
                    {{ ucfirst(auth()->user()->role) }} Account
                </p>

                <p class="text-xs text-blue-200">
                    {{ auth()->user()->name }}
                </p>

            </div>

        </div>


        <nav class="px-4 mt-6 flex-1">

            <p class="text-xs uppercase tracking-widest
                      text-blue-300 px-3 mb-3">
                Modules
            </p>


            <a
                href="{{ auth()->user()->role === 'admin'
                    ? route('admin.dashboard')
                    : route('staff.dashboard') }}"
                class="flex items-center gap-3 px-3 py-3
                       rounded-lg text-blue-100
                       hover:bg-white/10 transition"
            >
                <span>▥</span>

                <span class="text-sm">
                    Dashboard
                </span>
            </a>


            @if (auth()->user()->role === 'admin')

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

            @endif


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


            <a
                href="{{ route('admin.inventory.view') }}"
                class="flex items-center gap-3 px-3 py-3
                       rounded-lg bg-white/15 text-white"
            >
                <span>◉</span>

                <span class="text-sm">
                    View Inventory
                </span>
            </a>

        </nav>


        <div class="px-4 py-5 border-t border-blue-400/20">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full text-left px-3 py-3
                           text-blue-100
                           hover:bg-white/10 rounded-lg"
                >
                    Sign Out
                </button>

            </form>

        </div>

    </aside>


    {{-- MAIN --}}
    <main class="flex-1 p-8 overflow-auto">

        <div class="max-w-7xl mx-auto">

            <div class="mb-7">

                <h1 class="text-3xl font-bold text-[#183984]">
                    View Inventory
                </h1>

                <p class="text-sm text-blue-500 mt-1">
                    View current inventory records.
                </p>

            </div>


            {{-- INVENTORY TABLE --}}
            <div class="bg-white rounded-2xl
                        border border-blue-100
                        shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">

                    <h2 class="text-lg font-semibold text-blue-800">
                        Inventory Records
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Read-only inventory information.
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-700 text-white">

                        <tr>

                            <th class="px-5 py-4 text-left">
                                Item Name
                            </th>

                            <th class="px-5 py-4 text-left">
                                Category
                            </th>

                            <th class="px-5 py-4 text-left">
                                Quantity
                            </th>

                            <th class="px-5 py-4 text-left">
                                Maximum Capacity
                            </th>

                            <th class="px-5 py-4 text-left">
                                Reorder Level
                            </th>

                            <th class="px-5 py-4 text-left">
                                Unit
                            </th>

                            <th class="px-5 py-4 text-left">
                                Status
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @forelse ($items as $item)

                            @php

                                if (
                                    $item->quantity
                                    <= $item->reorder_level
                                ) {

                                    $status = 'Low';
                                    $statusClass =
                                        'bg-red-100 text-red-700';

                                } elseif (
                                    $item->quantity
                                    >= $item->max_capacity
                                ) {

                                    $status = 'Full';
                                    $statusClass =
                                        'bg-green-100 text-green-700';

                                } else {

                                    $status = 'Medium';
                                    $statusClass =
                                        'bg-yellow-100 text-yellow-700';

                                }

                            @endphp


                            <tr class="border-b border-gray-100">

                                <td class="px-5 py-4
                                           font-semibold text-blue-900">

                                    {{ $item->item_name }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $item->category }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $item->quantity }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $item->max_capacity }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $item->reorder_level }}

                                </td>


                                <td class="px-5 py-4">

                                    {{ $item->unit }}

                                </td>


                                <td class="px-5 py-4">

                                    <span
                                        class="px-3 py-1 rounded-full
                                               text-xs font-semibold
                                               {{ $statusClass }}"
                                    >

                                        {{ $status }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="px-5 py-10
                                           text-center text-gray-500"
                                >
                                    No inventory records found.
                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>