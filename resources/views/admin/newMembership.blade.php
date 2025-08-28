@extends('layouts.app')

@section('title', 'Memberships Dashboard')

@section('content')
    <div class="max-w-full mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-green-700">All Memberships</h1>
        </div>

        @if ($newMemberships->count())
            <div class="overflow-x-auto rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-green-400 bg-white border-collapse">
                    <thead class="bg-green-600 text-white sticky top-0">
                        <tr>
                            @foreach (['ID', 'NGO Name', 'Director', 'Email', 'Networks', 'Focal Points', 'Date', 'Applications', 'Action'] as $head)
                                <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider border">
                                    {{ $head }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($newMemberships as $membership)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-4 py-2 border font-medium">{{ $membership->id }}</td>
                                <td class="px-4 py-2 border">{{ $membership->org_name_en }}</td>
                                <td class="px-4 py-2 border">{{ $membership->director_name }}</td>
                                <td class="px-4 py-2 border break-words">{{ $membership->director_email }}</td>

                                {{-- Networks --}}
                                <td class="px-4 py-2 border max-w-xs">
                                    <div class="max-h-16 overflow-y-auto">
                                        @foreach ($membership->membershipUploads as $upload)
                                            @foreach ($upload->networks as $network)
                                                <span
                                                    class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs mb-1">
                                                    {{ $network->network_name }}
                                                </span><br>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </td>

                                {{-- Focal Points --}}
                                <td class="px-4 py-2 border max-w-xs">
                                    <div class="max-h-16 overflow-y-auto">
                                        @foreach ($membership->membershipUploads as $upload)
                                            @foreach ($upload->focalPoints as $focal)
                                                <span
                                                    class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mb-1">
                                                    {{ $focal->name }} ({{ $focal->position }})
                                                </span><br>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td class="px-4 py-2 border">
                                    @foreach ($membership->membershipUploads as $upload)
                                        {{ $upload->created_at->format('d M Y') }}<br>
                                    @endforeach
                                </td>

                                {{-- Applications --}}
                                <td class="px-4 py-2 border text-sm">
                                    <div class="max-h-16 overflow-y-auto space-y-2">
                                        @foreach ($membership->membershipUploads as $upload)
                                            <div class="border rounded p-2 mb-2 bg-gray-50 shadow-sm">
                                                <ul class="list-disc list-inside space-y-1 text-green-700">
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
                                                        'goal' => 'Goal',
                                                    ] as $field => $label)
                                                        @if (!empty($upload->$field))
                                                            @php
                                                                $fileUrl = asset('storage/' . $upload->$field);
                                                                $extension = strtolower(
                                                                    pathinfo($fileUrl, PATHINFO_EXTENSION),
                                                                );
                                                                $isImage = in_array($extension, [
                                                                    'jpg',
                                                                    'jpeg',
                                                                    'png',
                                                                    'gif',
                                                                    'webp',
                                                                ]);
                                                                $isDoc = in_array($extension, [
                                                                    'doc',
                                                                    'docx',
                                                                    'pdf',
                                                                ]);
                                                                $link = $isDoc
                                                                    ? 'https://docs.google.com/gview?url=' .
                                                                        urlencode($fileUrl) .
                                                                        '&embedded=true'
                                                                    : $fileUrl;
                                                            @endphp

                                                            <li>
                                                                @if ($field === 'signature' && $isImage)
                                                                    <img src="{{ $fileUrl }}" alt="Signature"
                                                                        class="h-16 border rounded">
                                                                @else
                                                                    <a href="{{ $extension === 'pdf' ? $fileUrl : $link }}"
                                                                        target="_blank"
                                                                        class="underline hover:text-green-900">
                                                                        {{ $label }}{{ $isDoc ? ' (Preview)' : '' }}
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>


                                {{-- Action Buttons --}}
                                <td class="px-4 py-2 border text-center space-x-2">
                                    <button
                                        class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">View</button>
                                    <button
                                        class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-600 mt-6">No memberships found.</p>
        @endif
    </div>
@endsection
