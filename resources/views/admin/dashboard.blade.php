@extends('layouts.app')

@section('title', 'Admin Dashboard - Memberships')

@section('content')
<div class="max-w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Memberships Dashboard</h1>
        <div class="text-sm text-gray-600">
            Total: {{ $memberships->total() }} submissions
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">NGO Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">Director Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">Membership</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">Networks</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">Focal Points</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider border-r border-green-100">Submitted By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Submitted At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($memberships as $membership)
                <tr class="hover:bg-green-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap border-r border-green-100 text-sm text-gray-700">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-green-100 text-sm font-semibold text-gray-900">
                        {{ $membership->ngo_name ?: 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-green-100 text-sm text-gray-700">
                        {{ $membership->director_name ?: 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-green-100 text-sm text-gray-700">
                        @if($membership->membership_status)
                            <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-xs font-semibold">Yes</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 px-2 py-0.5 rounded-full text-xs font-semibold">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-green-100 text-sm text-gray-700 max-w-xs truncate" 
                        title="{{ $membership->networks->pluck('network_name')->join(', ') }}">
                        {{ $membership->networks->pluck('network_name')->join(', ') ?: 'None' }}
                    </td>
                    <td class="px-6 py-4 border-r border-green-100 text-sm text-gray-700 max-w-xs">
                        @forelse($membership->focalPoints as $fp)
                            <div class="mb-2 p-2 border rounded bg-green-50">
                                <strong class="text-green-800">{{ $fp->network_name }}</strong><br />
                                {{ $fp->name }} ({{ $fp->sex }})<br />
                                {{ $fp->position }}<br />
                                <a href="mailto:{{ $fp->email }}" class="text-green-600 underline hover:text-green-800">{{ $fp->email }}</a><br />
                                <a href="tel:{{ $fp->phone }}" class="text-green-600 underline hover:text-green-800">{{ $fp->phone }}</a>
                            </div>
                        @empty
                            <span class="text-gray-500">No focal points</span>
                        @endforelse
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-green-100 text-sm text-gray-700">
                        @if($membership->user)
                            <div>
                                <div class="font-medium">{{ $membership->user->name }}</div>
                                <div class="text-gray-500">{{ $membership->user->email }}</div>
                                <div class="text-xs text-gray-400">{{ $membership->user->ngo }}</div>
                            </div>
                        @else
                            <span class="text-red-500">Unknown User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ $membership->created_at->format('Y-m-d H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                        No membership submissions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $memberships->links() }}
    </div>
</div>
@endsection
