@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📊 Membership Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-12 mb-8">
        <!-- Total New Membership -->
        <div class="">
            <div class="mb-4 relative w-60 bg-blue-600 text-white text-sm text-center px-4 py-1 rounded-full">
                <span class="bg-blue-600 text-white text-sm px-4 py-1 rounded-full">
                    New Membership
                </span>
            </div>
            <div class="w-60 bg-white shadow p-6 relative rounded-lg hover:shadow-lg transition">
                <div class="flex justify-center mb-4 mt-4">
                    <div>
                        <img src="/new.jpg" alt="New Membership" class="w-16 h-16">
                    </div>
                </div>
                <div class="text-3xl font-bold text-center text-gray-800">{{ $totalNew }}</div>
            </div>
        </div>

        <!-- Total Accept Membership -->
        <div class="">
            <div class="mb-4 relative w-60 bg-green-600 text-white text-sm text-center px-4 py-1 rounded-full">
                <span class="bg-green-600 text-white text-sm px-4 py-1 rounded-full">
                    Accept Membership
                </span>
            </div>
            <div class="w-60 bg-white shadow p-6 relative rounded-lg hover:shadow-lg transition">
                <div class="flex justify-center mb-4 mt-4">
                    <div>
                        <img src="/approved.jpg" alt="Accept Membership" class="w-16 h-16">
                    </div>
                </div>
                <div class="text-3xl font-bold text-center text-gray-800">{{ $totalAccept }}</div>
            </div>
        </div>

        <!-- Total Request Membership -->
        <div class="">
            <div class="mb-4 relative w-60 bg-yellow-400 text-white text-sm text-center px-4 py-1 rounded-full">
                <span class="bg-yellow-400 text-white text-sm px-4 py-1 rounded-full">
                    Request Membership
                </span>
            </div>
            <div class="w-60 bg-white shadow p-6 relative rounded-lg hover:shadow-lg transition">
                <div class="flex justify-center mb-4 mt-4">
                    <div>
                        <img src="/request.jpg" alt="Request Membership" class="w-16 h-16">
                    </div>
                </div>
                <div class="text-3xl font-bold text-center text-gray-800">{{ $totalRequest }}</div>
            </div>
        </div>

        <!-- Total Cancel Membership -->
        <div class="">
            <div class="mb-4 relative w-60 bg-red-500 text-white text-sm text-center px-4 py-1 rounded-full">
                <span class="bg-red-500 text-white text-sm px-4 py-1 rounded-full">
                    Cancel Membership
                </span>
            </div>
            <div class="w-60 bg-white shadow p-6 relative rounded-lg hover:shadow-lg transition">
                <div class="flex justify-center mb-4 mt-4">
                    <div>
                        <img src="/cencel.jpg" alt="Cancel Membership" class="w-16 h-16">
                    </div>
                </div>
                <div class="text-3xl font-bold text-center text-gray-800">{{ $totalCancel }}</div>
            </div>
        </div>

        <!-- Total Membership -->
        <div class="">
            <div class="mb-4 relative w-60 bg-gray-500 text-white text-sm text-center px-4 py-1 rounded-full">
                <span class="bg-gray-500 text-white text-sm px-2 py-1 rounded-full">
                    Total Membership
                </span>
            </div>
            <div class="w-60 bg-white shadow p-6 relative rounded-lg hover:shadow-lg transition">
                <div class="flex justify-center mb-4 mt-4">
                    <div>
                        <img src="/total.jpg" alt="Total Membership" class="w-16 h-16">
                    </div>
                </div>
                <div class="text-3xl font-bold text-center text-gray-800">{{ $totalMembership }}</div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Line Chart -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="font-semibold text-lg text-green-700 mb-4 flex items-center">
                <span class="mr-2"></span> Membership Growth
            </h2>
            <canvas id="lineChart" class="h-40"></canvas>
        </div>

        <!-- Pie Chart -->
        <div
            class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition flex flex-col md:flex-row items-center md:items-start">
            <div class="mb-4 md:mb-0 md:mr-6">
                <h2 class="font-semibold text-lg text-green-700 mb-2">Membership Overview</h2>
                <ul class="text-base mt-4 md:mt-12 ml-2 md:ml-12">
                    <li class="flex items-center mb-1">
                        <span class="w-3 h-3 inline-block mr-2" style="background-color: #facc15;"></span> Request
                    </li>
                    <li class="flex items-center mb-1">
                        <span class="w-3 h-3 inline-block mr-2" style="background-color: #22c55e;"></span> Accept
                    </li>
                    <li class="flex items-center mb-1">
                        <span class="w-3 h-3 inline-block mr-2" style="background-color: #ef4444;"></span> Cancel
                    </li>
                    <li class="flex items-center mb-1">
                        <span class="w-3 h-3 inline-block mr-2" style="background-color: #3b82f6;"></span> Total New
                    </li>
                </ul>
            </div>
            <div class="w-48 h-48 md:w-80 md:h-80 mt-5 md:mt-10">
                <canvas id="pieChart"></canvas>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Line Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Memberships',
                    data: @json($monthlyData),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Request', 'Accept', 'Cancel', 'Total New'],
                datasets: [{
                    data: [{{ $totalRequest }}, {{ $totalAccept }}, {{ $totalCancel }},
                        {{ $totalNew }}
                    ],
                    backgroundColor: ['#facc15', '#22c55e', '#ef4444', '#3b82f6'],
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false // we use custom HTML legend instead
                    }
                }
            }
        });
    </script>
@endpush
