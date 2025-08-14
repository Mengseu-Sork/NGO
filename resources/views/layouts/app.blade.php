<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'NGOF Admin')</title>
    <link rel="icon" href="/logo.png" type="image/png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="h-full flex flex-col">

    <nav class="bg-green-700 text-white shadow">
        <div class="max-w-full mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-12">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                        class="text-xl font-bold hover:text-green-300">
                            NGOF Admin
                        </a>
                        <a href="{{ route('admin.dashboard') }}" 
                        class="hover:text-green-300 {{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-white pb-1' : '' }}">
                            Memberships
                        </a>
                        <a href="{{ route('admin.user') }}" 
                        class="hover:text-green-300 {{ request()->routeIs('admin.user') ? 'border-b-2 border-white pb-1' : '' }}">
                            No Membership
                        </a>
                    @elseif(auth()->user()->role === 'user')
                        <a href="{{ route('profile') }}" 
                        class="text-xl font-bold hover:text-green-300">
                            My Profile
                        </a>
                    @endif
                </div>
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-800 px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <main class="flex-grow px-6 py-8">
        @yield('content')
    </main>

</body>
</html>
