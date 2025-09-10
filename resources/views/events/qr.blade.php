@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-6">

        {{-- Page Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-green-700">
                QR Code Events
            </h1>
            <p class="mt-2 text-gray-600">Scan the QR code below to register for your event</p>
        </div>

        {{-- Events Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($events as $event)
                @php
                    // Badge
                    $today = Carbon\Carbon::today();
                    $badgeColor = $event->end_date >= $today ? 'bg-green-500' : 'bg-red-500';
                    $badgeText = $event->end_date >= $today ? 'Upcoming' : 'Past';

                    // Format date and time
                    $startDate = Carbon\Carbon::parse($event->start_date)->format('D, d M Y');
                    $endDate = Carbon\Carbon::parse($event->end_date)->format('D, d M Y');
                    $startTime = Carbon\Carbon::parse($event->start_time)->format('g:i A');
                    $endTime = Carbon\Carbon::parse($event->end_time)->format('g:i A');
                @endphp

                <div
                    class="relative bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-transform transform hover:-translate-y-1 duration-300 border-t-8 border-b-8 border-green-600">

                    {{-- Event Badge --}}
                    <span
                        class="absolute top-3 left-3 px-3 py-1 text-white font-semibold rounded-full text-sm {{ $badgeColor }}">
                        {{ $badgeText }}
                    </span>

                    {{-- Event Content --}}
                    <div class="p-6 flex flex-col items-center">

                        {{-- Event Title --}}
                        <h2 class="text-xl font-bold text-gray-800 mb-4 mt-4 text-center">
                            {{ $event->title }}
                        </h2>

                        {{-- QR Code --}}
                        @if ($event->qr_code_path)
                            <div class="flex flex-col items-center space-y-2">
                                <img src="{{ asset('storage/' . $event->qr_code_path) }}"
                                    alt="QR Code for {{ $event->title }}"
                                    class="w-40 h-40 border rounded-xl shadow-md hover:scale-105 transition-transform duration-300">
                                <p class="text-sm text-gray-500">Scan to register</p>
                            </div>
                        @else
                            <p class="text-red-500 italic">No QR code available</p>
                        @endif

                        {{-- Event Info --}}
                        <div class="mt-4 space-y-4 text-gray-700 text-sm text-center">

                            {{-- Date --}}
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>
                                    <span class="font-semibold">Date:</span>
                                    @if ($startDate === $endDate)
                                        {{ $startDate }}
                                    @else
                                        {{ $startDate }} - {{ $endDate }}
                                    @endif
                                </p>

                            </div>

                            {{-- Time --}}
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p><span class="font-semibold">Time:</span> {{ $startTime }} - {{ $endTime }}</p>
                            </div>

                            {{-- Location --}}
                            @if ($event->location)
                                <div class="flex justify-center gap-2">
                                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zm4.95 2.45a2.5 2.5 0 100 5 2.5 2.5 0 000-5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p><span class="font-semibold">Location:</span> {{ $event->location }}</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
