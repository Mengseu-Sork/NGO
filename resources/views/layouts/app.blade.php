<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-white shadow-sm px-4 sm:px-6 md:px-8 py-4" x-data="{ open: false }">
        <div class="flex items-center justify-between md:justify-start space-x-4 md:space-x-10">
            <!-- Logo -->
            <img src="/logo.png" class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16" alt="logo">

            <!-- Hamburger (Phones & Tablets) -->
            <button @click="open = !open" class="sm:block md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center space-x-12">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="font-semibold border-b-2 py-1 text-xs md:text-lg {{ request()->routeIs('admin.dashboard') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Dashboard
                    </a>
                    <!-- Membership Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <!-- Parent Button -->
                        <button @click="open = !open"
                            class="font-semibold border-b-2 py-1 text-xs md:text-lg flex items-center space-x-2
                                {{ request()->routeIs('admin.newMembership') || request()->routeIs('admin.membership') || request()->routeIs('admin.user') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                            <span>Memberships</span>
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 mt-1 w-36 bg-white border rounded shadow-lg z-50 flex flex-col">
                            <a href="{{ route('admin.newMembership') }}"
                                class="px-3 py-2 text-xs md:text-sm text-gray-700 hover:bg-green-100 hover:text-green-700 {{ request()->routeIs('admin.newMembership') ? 'font-semibold text-green-700' : '' }}">
                                New Membership
                            </a>
                            <a href="{{ route('admin.membership') }}"
                                class="px-3 py-2 text-xs md:text-sm text-gray-700 hover:bg-green-100 hover:text-green-700 {{ request()->routeIs('admin.membership') ? 'font-semibold text-green-700' : '' }}">
                                Old Membership
                            </a>
                            <a href="{{ route('admin.user') }}"
                                class="px-3 py-2 text-xs md:text-sm text-gray-700 hover:bg-green-100 hover:text-green-700 {{ request()->routeIs('admin.user') ? 'font-semibold text-green-700' : '' }}">
                                Non Membership
                            </a>
                        </div>
                    </div>

                    {{-- Event --}}
                    <a href="#"
                        class="font-semibold border-b-2 py-1 text-xs md:text-lg {{ request()->routeIs('') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Events
                    </a>

                    {{-- Report --}}
                    <a href="#"
                        class="font-semibold border-b-2 py-1 text-xs md:text-lg {{ request()->routeIs('') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Reports
                    </a>
                @elseif(auth()->user()->role === 'user')
                    <a href="{{ route('profile') }}"
                        class="font-semibold border-b-2 py-1 text-xs md:text-lg flex items-center space-x-2
                                {{ request()->routeIs('profile') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Home
                    </a>
                    <a href="#"
                        class="font-semibold border-b-2 py-1 text-xs md:text-lg flex items-center space-x-2 {{ request()->routeIs('') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Events
                    </a>
                    <a href="#"
                        class="font-semibold border-b-2 py-1 text-xs md:text-lg flex items-center space-x-2 {{ request()->routeIs('') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        My Report
                    </a>
                @endif
            </nav>
        </div>

        <!-- Right Section: Notification + User (Desktop Only) -->
        <div class="hidden md:flex items-center space-x-4 absolute right-6 top-7">

            <!-- User Avatar + Name -->
            <div class="flex items-center space-x-4">
                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A11.955 11.955 0 0112 15c2.486 0 4.779.755 6.879 2.045M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="text-gray-600 text-xs md:text-sm">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </div>

        <!-- Mobile & Tablet Dropdown -->
        <div x-show="open" @click.away="open = false"
            class="absolute top-16 left-0 w-full bg-white shadow-md flex flex-col space-y-2 px-6 py-4 md:hidden z-50">
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="py-2 {{ request()->routeIs('admin.dashboard') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.membership') }}"
                    class="py-2 {{ request()->routeIs('admin.membership') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    Old Memberships
                </a>
                <a href="{{ route('admin.user') }}"
                    class="py-2 {{ request()->routeIs('admin.user') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    Non Memberships
                </a>
                <a href="{{ route('admin.newMembership') }}"
                    class="py-2 {{ request()->routeIs('admin.newMembership') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    New Memberships
                </a>
                <a href="#"
                    class="py-2 {{ request()->routeIs('') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    Events
                </a>
            @elseif(auth()->user()->role === 'user')
                <a href="{{ route('profile') }}"
                    class="py-2 {{ request()->routeIs('profile') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    Home
                </a>
                <a href="#"
                    class="py-2 {{ request()->routeIs('') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    Events
                </a>
                <a href="#"
                    class="py-2 {{ request()->routeIs('') ? 'text-green-700 font-semibold' : 'text-gray-700 hover:text-green-600' }}">
                    My Report
                </a>
            @endif

            <!-- Mobile User + Notification -->
            <div class="border-t pt-3 flex justify-between items-center">
                <button class="relative p-2 rounded-full hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span
                        class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">2</span>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A11.955 11.955 0 0112 15c2.486 0 4.779.755 6.879 2.045M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="text-gray-600">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="flex-grow px-6 py-6">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
