<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Record Stock-In - Bubbles & Drop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#edf4ff] min-h-screen">

<div class="min-h-screen flex">

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
                href="#"
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
                       rounded-lg bg-white/15 text-white"
            >
                <span>↓</span>
                <span class="text-sm">
                    Record Stock-In
                </span>
            </a>


            <a
                href="#"
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
                href="#"
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


        <div class="px-4 py-5 border-t border-blue-400/20">

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full text-left px-3 py-3
                           text-blue-100 hover:bg-white/10
                           rounded-lg"
                >
                    Sign Out
                </button>

            </form>

        </div>

    </aside>


    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8">

        <div class="max-w-4xl mx-auto">

            <div class="mb-7">

                <h1 class="text-3xl font-bold text-[#183984]">
                    Record Stock-In
                </h1>

                <p class="text-sm text-blue-500 mt-1">
                    Record newly received inventory items.
                </p>

            </div>


            @if (session('error'))

                <div class="mb-6 rounded-lg
                            bg-red-100 border border-red-300
                            text-red-700 px-4 py-3">

                    {{ session('error') }}

                </div>

            @elseif (session('success'))

                <div class="mb-6 rounded-lg
                            bg-green-100 border border-green-300
                            text-green-700 px-4 py-3">

                    {{ session('success') }}

                </div>

            @endif


            <div class="bg-white rounded-2xl shadow-sm
                        border border-blue-100 p-8">

                <form
                    method="POST"
                    action="{{ route('admin.inventory.stock-in.store') }}"
                    class="space-y-6"
                >

                    @csrf


                    {{-- ITEM --}}
                    <div>

                        <label
                            for="inventory_item_id"
                            class="block text-sm font-semibold
                                   text-gray-700 mb-2"
                        >
                            Inventory Item
                        </label>

                        <select
                            id="inventory_item_id"
                            name="inventory_item_id"
                            required
                            class="w-full rounded-lg
                                   border-gray-300 px-4 py-3"
                        >

                            <option value="">
                                Select inventory item
                            </option>

                            @foreach ($items as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(
                                        old('inventory_item_id')
                                        == $item->id
                                    )
                                >
                                    {{ $item->item_name }}
                                    —
                                    Current:
                                    {{ $item->quantity }}
                                    {{ $item->unit }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- QUANTITY --}}
                    <div>

                        <label
                            for="quantity"
                            class="block text-sm font-semibold
                                   text-gray-700 mb-2"
                        >
                            Quantity Received
                        </label>

                        <input
                            type="number"
                            id="quantity"
                            name="quantity"
                            value="{{ old('quantity') }}"
                            min="0.01"
                            step="0.01"
                            required
                            placeholder="Enter quantity received"
                            class="w-full rounded-lg
                                   border-gray-300 px-4 py-3"
                        >

                    </div>


                    {{-- DATE --}}
                    <div>

                        <label
                            for="date"
                            class="block text-sm font-semibold
                                   text-gray-700 mb-2"
                        >
                            Date
                        </label>

                        <input
                            type="date"
                            id="date"
                            name="date"
                            value="{{ old(
                                'date',
                                now()->format('Y-m-d')
                            ) }}"
                            required
                            class="w-full rounded-lg
                                   border-gray-300 px-4 py-3"
                        >

                    </div>


                    {{-- SUPPLIER --}}
                    <div>

                        <label
                            for="supplier"
                            class="block text-sm font-semibold
                                   text-gray-700 mb-2"
                        >
                            Supplier
                        </label>

                        <input
                            type="text"
                            id="supplier"
                            name="supplier"
                            value="{{ old('supplier') }}"
                            required
                            placeholder="Enter supplier name"
                            class="w-full rounded-lg
                                   border-gray-300 px-4 py-3"
                        >

                    </div>


                    <div class="flex gap-3 pt-4">

                        <button
                            type="submit"
                            class="flex-1 bg-blue-700
                                   text-white font-semibold
                                   py-3 rounded-lg
                                   hover:bg-blue-800 transition"
                        >
                            Record Stock-In
                        </button>

                        <a
                            href="{{ auth()->user()->role === 'admin'
                                ? route('admin.dashboard')
                                : route('staff.dashboard') }}"
                            class="flex-1 text-center
                                   bg-gray-200 text-gray-700
                                   font-semibold py-3 rounded-lg
                                   hover:bg-gray-300 transition"
                        >
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </main>

</div>

</body>
</html>