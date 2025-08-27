
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-white shadow-sm px-12 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-14">
            <img src="/logo.png" class="w-28 h-16" alt="logo">
            <nav class="flex items-center space-x-14">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="font-semibold border-b-2
                {{ request()->routeIs('admin.dashboard') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.membership') }}"
                        class="font-semibold border-b-2
                {{ request()->routeIs('admin.membership') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Old Memberships
                    </a>
                    <a href="{{ route('admin.user') }}"
                        class="font-semibold border-b-2
                {{ request()->routeIs('admin.user') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Non Memberships
                    </a>
                    </a>
                    <a href="#"
                        class="font-semibold border-b-2
                {{ request()->routeIs('') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        New Memberships
                    </a>
                    <a href="#"
                        class="font-semibold border-b-2
                {{ request()->routeIs('') ? 'text-green-700 border-green-700' : 'text-gray-600 border-transparent hover:text-green-600 hover:border-green-600' }}">
                        Events
                    </a>
                @elseif(auth()->user()->role === 'user')
                    <a href="{{ route('profile') }}" 
                        class="text-xl font-bold hover:text-green-300">
                            My Profile
                    </a>
                @endif
            </nav>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Notification Icon -->
            <button class="relative p-2 rounded-full hover:bg-gray-100 transition">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <!-- Notification badge -->
                <span
                    class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">2</span>
            </button>
            <!-- User Avatar -->
            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 relative">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A11.955 11.955 0 0112 15c2.486 0 4.779.755 6.879 2.045M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>

            <!-- User Name -->
            <span class="text-gray-600">{{ Auth::user()->name ?? 'Admin' }}</span>
        </div>

    </header>

    <!-- Page Content -->
    <main class="flex-grow px-6 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
