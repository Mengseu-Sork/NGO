@extends('layouts.app')

@section('title', 'Admin Dashboard - Memberships')

@section('content')
<div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-semibold mb-6 text-gray-900">All Users</h1>

    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
        <table class="min-w-full bg-white">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-green-700">ID</th>
                    <th class="px-12 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-green-700">Name</th>
                    <th class="px-24 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-green-700">NGO</th>
                    <th class="px-12 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-green-700">Email</th>
                    <th class="px-12 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b border-green-700">Registered At</th>
                    <th class="px-12 py-3 text-xs font-semibold uppercase tracking-wider border-b border-green-700">Membership</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="hover:bg-green-50 transition-colors duration-200">
                    <td class="px-6 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $loop->iteration }}</td>
                    <td class="px-12 py-4 text-sm text-gray-900 border-b border-gray-200">{{ $user->name }}</td>
                    <td class="px-24 py-4 text-sm text-gray-700 border-b border-gray-200">{{ $user->ngo }}</td>
                    <td class="px-12 py-4 text-sm text-gray-700 border-b border-gray-200 break-words max-w-xs">{{ $user->email }}</td>
                    <td class="px-12 py-4 text-sm text-gray-500 border-b border-gray-200">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-12 py-4 text-center text-sm border-b border-gray-200">
                        @if ($user->membership && $user->membership->membership_status)
                            <span class="inline-block px-2 py-1 text-green-800 bg-green-200 rounded-full text-xs font-semibold">Yes Membership</span>
                        @else
                            <span class="inline-block px-2 py-1 text-red-800 bg-red-200 rounded-full text-xs font-semibold">No Membership</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
