@extends('layouts.app')

@section('title', 'Memberships Dashboard')

@section('content')
    <div class="max-w-full mx-auto py-2">
        <div class="flex justify-between items-center mb-4">
            {{-- Breadcrumbs --}}
            {{-- Page Title --}}
            <h1 class="text-3xl font-extrabold mb-10 text-green-900">All Memberships</h1>
            {{-- Tailwind Export Dropdown --}}
            <div x-data="{ open: false }" class="relative inline-block text-left mb-4">
                <button @click="open = !open" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-green-600 text-white text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    aria-haspopup="true" :aria-expanded="open.toString()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4l-8 8 4 4 8-8" />
                    </svg>
                    Export
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="origin-top-right absolute right-0 mt-2 w-28 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                    role="menu" aria-orientation="vertical" aria-labelledby="export-menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="{{ route('memberships.exportPDF') }}"
                            class="text-gray-700 block px-4 py-2 text-sm hover:bg-green-100 flex items-center space-x-2"
                            role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M12 2L3 7v13h18V7l-9-5zM11 18v-6h2v6h-2z" />
                            </svg>
                            <span>PDF</span>
                        </a>
                        <a href="{{ route('memberships.exportExcel') }}"
                            class="text-gray-700 block px-4 py-2 text-sm hover:bg-green-100 flex items-center space-x-2"
                            role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 4h14v16H5zM9 8v8M15 8v8" stroke="#fff" stroke-width="2" />
                            </svg>
                            <span>Excel</span>
                        </a>
                        <a href="{{ route('memberships.exportWord') }}"
                            class="text-gray-700 block px-4 py-2 text-sm hover:bg-green-100 flex items-center space-x-2"
                            role="menuitem" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M5 4h14v16H5zM7 8h10M7 12h10M7 16h10" stroke="#fff" stroke-width="2" />
                            </svg>
                            <span>Word</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Memberships Table --}}
        @if ($memberships->count())
            <div class="overflow-x-auto rounded-lg shadow ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-gray-200 bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                ID</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                NGO Name</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Director</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Position</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Networks</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Applications</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-white bg-green-600 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($memberships as $membership)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900">
                                    {{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900">
                                    {{ $membership->ngo_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">
                                    {{ $membership->director_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $membership->director_email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $membership->alt_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-normal text-sm max-h-26 overflow-y-auto text-gray-700">
                                    @if ($membership->networks->count())
                                        <ul class="list-disc list-inside space-y-1 max-h-28 overflow-auto">
                                            @foreach ($membership->networks as $network)
                                                {{ $network->network_name }}
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="italic text-gray-400">No networks</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ optional($membership->created_at)->format('d M Y') ?? 'N/A' }}</td>
                                <td
                                    class="px-6 py-4 whitespace-normal text-sm text-gray-700 max-h-12 w-1/5 overflow-y-auto">
                                    @if ($membership->applications->count())
                                        <ul class="list-disc list-inside space-y-4 max-h-12 overflow-auto">
                                            @foreach ($membership->applications as $app)
                                                <div class="border rounded p-3 bg-gray-50">
                                                    <p><strong>Date:</strong> {{ $app->date?->format('d M Y') ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>Mailing Address:</strong>
                                                        {{ $app->mailing_address ?? 'N/A' }}</p>

                                                    <p><strong>Facebook:</strong> {{ $app->facebook ?? 'N/A' }}</p>

                                                    <p><strong>Website:</strong>
                                                        <a href="{{ $app->website }}" target="_blank"
                                                            class="text-blue-600 hover:underline">
                                                            {{ $app->website ?? 'N/A' }}
                                                        </a>
                                                    </p>


                                                    <p><strong>Communication Channels:</strong>
                                                        @if (is_array($app->comm_channels) && count($app->comm_channels))
                                                            {{ implode(', ', $app->comm_channels) }}
                                                        @else
                                                            None
                                                        @endif
                                                    </p>

                                                    <p><strong>Communication Phones:</strong></p>
                                                    @if (is_array($app->comm_phones) && count($app->comm_phones))
                                                        <ul class="list-disc list-inside ml-4">
                                                            @foreach (array_slice($app->comm_phones, 0, 3) as $channel => $phone)
                                                                <li>
                                                                    {{ ucfirst($channel) }}: 
                                                                    <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="text-blue-600 hover:underline">
                                                                        {{ $phone }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="italic text-gray-400 ml-4">None</p>
                                                    @endif

                                                    <p><strong>Vision:</strong> {{ $app->vision ?? 'N/A' }}</p>
                                                    <p><strong>Mission:</strong> {{ $app->mission ?? 'N/A' }}</p>
                                                    <p><strong>Goal:</strong> {{ $app->goal ?? 'N/A' }}</p>

                                                    <div class="mt-2">
                                                        <strong>Files:</strong>
                                                        <ul class="list-disc list-inside text-blue-600 space-y-1">
                                                        @foreach ([
                                                            'letter' => 'Letter',
                                                            'constitution' => 'Constitution',
                                                            'activities' => 'Activities',
                                                            'funding' => 'Funding',
                                                            'registration' => 'Registration',
                                                            'strategic_plan' => 'Strategic Plan',
                                                            'fundraising_strategy' => 'Fundraising Strategy',
                                                            'audit_report' => 'Audit Report',
                                                            'signature' => 'Signature',
                                                        ] as $field => $label)
                                                            @if (!empty($app->$field))
                                                                @php
                                                                    $fileUrl = asset('storage/' . $app->$field);
                                                                    $extension = strtolower(pathinfo($fileUrl, PATHINFO_EXTENSION));
                                                                @endphp
                                                                <li>
                                                                    @if ($extension === 'pdf')
                                                                        <!-- Direct PDF link -->
                                                                        <a href="{{ $fileUrl }}" target="_blank" class="underline hover:text-blue-800">
                                                                            {{ $label }}
                                                                        </a>
                                                                    @elseif (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                                                                        <!-- Use Google Docs Viewer for Office files -->
                                                                        <a href="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true" target="_blank" class="underline hover:text-blue-800">
                                                                            {{ $label }} (Preview)
                                                                        </a>
                                                                    @else
                                                                        <!-- For images or other file types, just open normally -->
                                                                        <a href="{{ $fileUrl }}" target="_blank" class="underline hover:text-blue-800">
                                                                            {{ $label }}
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="italic text-gray-400">No applications</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 space-x-2">
                                    {{-- View Details Button --}}
                                    <a href="{{ route('admin.show', $membership->id) }}"
                                        class="inline-flex items-center gap-2 px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 transition"
                                        title="View Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-center">
                {{ $memberships->links() }}
            </div>
        @else
            <p class="text-center text-gray-600">No memberships found.</p>
        @endif
    </div>
@endsection
