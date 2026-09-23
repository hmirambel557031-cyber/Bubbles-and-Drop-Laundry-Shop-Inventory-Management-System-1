<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bubble & Drop Laundry</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-sky-100">

    <!-- Header -->
    <header class="relative bg-blue-800 text-white py-10 px-4">

        <div class="absolute left-4 top-4 z-10">
            <div class="relative inline-block" x-data="{ open: false }">
                <button type="button"
                    @click="open = !open"
                    class="flex items-center gap-2 rounded-xl border-2 border-blue-200 bg-white px-4 py-3 shadow-lg shadow-blue-900/10 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    style="color: #111827; font-size: 16px; font-weight: 700; line-height: 1.2;">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-100 text-lg" aria-hidden="true">👤</span>
                    <span style="color: #111827; display: inline-block;">Account</span>
                </button>

                <div x-show="open"
                    x-transition
                    class="absolute left-0 top-full mt-2 w-52 rounded-xl bg-white p-2 shadow-xl ring-1 ring-slate-200"
                    style="display: none;">
                    <a href="{{ route('login.staff') }}"
                        @click="open = false"
                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold"
                        style="color: #111827; text-decoration: none; display: flex; align-items: center;">
                        <span aria-hidden="true">👷</span>
                        <span>Staff Sign In</span>
                    </a>
                    <a href="{{ route('login.admin') }}"
                        @click="open = false"
                        class="mt-1 flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold"
                        style="color: #111827; text-decoration: none; display: flex; align-items: center;">
                        <span aria-hidden="true">🛡️</span>
                        <span>Admin Sign In</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h1 class="text-4xl font-bold">
                Welcome to Bubble & Drop!
            </h1>

            <p class="mt-2 text-lg text-blue-100">
                Choose the option you want to access today.
            </p>
        </div>

    </header>


    <!-- Main -->
    <main class="min-h-[60vh] flex items-center justify-center">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Check Laundry -->
            <a href="{{ route('customer.check-laundry') }}"
                class="w-72 h-64 bg-blue-100 border-2 border-blue-500
                      rounded-2xl flex flex-col items-center justify-center
                      hover:bg-blue-200 transition">

                <div class="w-24 h-24 bg-blue-300 rounded-xl
                            flex items-center justify-center">

                    <span class="text-5xl">
                        🔎
                    </span>

                </div>

                <h2 class="mt-5 text-2xl font-bold text-blue-900">
                    Check My Laundry
                </h2>

                <p class="mt-2 text-gray-600 text-center px-5">
                    Check the current status of your laundry.
                </p>

            </a>


            <!-- Avail Service -->
            <a href="{{ route('customer.avail-service') }}"
                class="w-72 h-64 bg-red-50 border-2 border-red-400
                      rounded-2xl flex flex-col items-center justify-center
                      hover:bg-red-100 transition">

                <div class="w-24 h-24 bg-red-200 rounded-xl
                            flex items-center justify-center">

                    <span class="text-5xl">
                        🧺
                    </span>

                </div>

                <h2 class="mt-5 text-2xl font-bold text-red-700">
                    Avail Service
                </h2>

                <p class="mt-2 text-gray-600 text-center px-5">
                    Start a new laundry service.
                </p>

            </a>

        </div>

    </main>


    <!-- Footer -->
    <footer class="bg-blue-800 text-white text-center py-5">

        <p class="font-semibold">
            Matina Aplaya Road
        </p>

        <p class="text-sm text-blue-200">
            Davao City, Davao Region
        </p>

    </footer>

</body>

</html>
