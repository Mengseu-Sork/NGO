@extends('layouts.app')

@section('title', 'Memberships Dashboard')

@section('content')
    <div class="max-w-full mx-auto px-2 md:px-6 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-green-700">All Memberships</h1>
        </div>

        {{-- Memberships Table --}}
        @if ($newMemberships->count())
            <div class="overflow-x-auto rounded-lg shadow ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-green-400 bg-white">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">ID</th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">NGO Name
                            </th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">Director
                            </th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">Email</th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">Networks
                            </th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">Focal
                                Points</th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">Date</th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">
                                Applications</th>
                            <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider border">Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-green-200">
                        @foreach ($newMemberships as $membership)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-3 py-2 border font-medium">{{ $membership->id }}</td>
                                <td class="px-3 py-2 border">{{ $membership->org_name_en }}</td>
                                <td class="px-3 py-2 border">{{ $membership->director_name }}</td>
                                <td class="px-3 py-2 border break-words">{{ $membership->director_email }}</td>

                                {{-- Networks --}}
                                <td class="px-3 py-2 border max-w-xs overflow-auto">
                                    @foreach ($membership->membershipUploads as $upload)
                                        @foreach ($upload->networks as $network)
                                            <span
                                                class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs mb-1">{{ $network->network_name }}</span><br>
                                        @endforeach
                                    @endforeach
                                </td>

                                {{-- Focal Points --}}
                                <td class="px-3 py-2 border max-w-xs overflow-auto">
                                    @foreach ($membership->membershipUploads as $upload)
                                        @foreach ($upload->focalPoints as $focal)
                                            <span
                                                class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mb-1">{{ $focal->name }}
                                                ({{ $focal->position }})</span><br>
                                        @endforeach
                                    @endforeach
                                </td>

                                {{-- Date --}}
                                <td class="px-3 py-2 border">
                                    @foreach ($membership->membershipUploads as $upload)
                                        {{ $upload->created_at->format('d M Y') }}<br>
                                    @endforeach
                                </td>

                                {{-- Application Data --}}
                                <td class="px-3 py-2 border max-h-64 overflow-y-auto text-sm">
                                    @foreach ($membership->membershipUploads as $upload)
                                        <div class="border rounded p-3 mb-2 bg-gray-50 shadow-sm">
                                            <ul class="list-disc list-inside space-y-1">
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
                                                        @endphp
                                                        <li>
                                                            @if ($extension === 'pdf')
                                                                <a href="{{ $fileUrl }}" target="_blank"
                                                                    class="underline text-green-700 hover:text-green-900">{{ $label }}</a>
                                                            @elseif (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                                                                <a href="https://docs.google.com/gview?url={{ urlencode($fileUrl) }}&embedded=true"
                                                                    target="_blank"
                                                                    class="underline text-blue-700 hover:text-blue-900">{{ $label }}
                                                                    (Preview)</a>
                                                            @else
                                                                <a href="{{ $fileUrl }}" target="_blank"
                                                                    class="underline text-gray-700 hover:text-gray-900">{{ $label }}</a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </td>

                                {{-- Action --}}
                                <td class="px-3 py-2 border text-center space-x-2">
                                    requested
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-600">No memberships found.</p>
        @endif
    </div>
@endsection
