@extends('layouts.app')
@section('content')

    <div class="max-w-full mx-auto mt-2 bg-white rounded-xl shadow-lg overflow-x-auto">
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 sm:p-6 bg-green-600 text-white rounded-t-xl">
            <h2 class="text-xl sm:text-2xl font-bold">
                All Events
            </h2>
            <button onclick="openModal()"
                class="mt-4 sm:mt-0 px-4 py-2 bg-green-500 hover:bg-green-700 transition rounded-lg text-sm sm:text-base font-semibold shadow-md">
                + Add Event
            </button>
        </div>

        @if ($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-emerald-200 text-sm sm:text-base">
                    <thead class="bg-emerald-100 text-emerald-600">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Start
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                End
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Location
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                Organizer
                            </th>
                            <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($events as $event)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                                    @if (strlen($event->title) > 30)
                                        {{ substr($event->title, 0, 30) . '...' }}
                                    @else
                                        {{ $event->title }}
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ $event->location ?? '-' }}</td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-gray-600">
                                    {{ $event->organizer ?? '-' }}</td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-center text-sm text-gray-700 relative">
                                    <div x-data="{ open: false }" class="inline-block text-left">

                                        <!-- Kebab Menu Button -->
                                        <button @click="open = !open"
                                            class="p-2 rounded hover:bg-gray-200 transition focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <circle cx="12" cy="5" r="1.5" />
                                                <circle cx="12" cy="12" r="1.5" />
                                                <circle cx="12" cy="19" r="1.5" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-2 sm:right-8 -mt-4 w-28 bg-white border border-gray-200 rounded-lg shadow-xl z-10 flex flex-col p-1 space-y-1 text-sm">
                                            <!-- View Details -->
                                            <a href="#"
                                                onclick='event.stopPropagation(); openEventDetailModal(@json($event));'
                                                class="flex items-center px-2 py-1 text-sm text-blue-700 hover:bg-blue-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('events.edit', $event) }}"
                                                @click.prevent="editEvent({{ $event->id }})"
                                                class="flex items-center px-2 py-1 text-sm text-green-700 hover:bg-green-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Delete -->
                                            <button @click="open = false; $refs.deleteModal.classList.remove('hidden')"
                                                class="flex items-center px-2 py-1 text-sm text-red-600 hover:bg-red-100 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div x-ref="deleteModal"
                                            class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div class="bg-white rounded-lg shadow-xl w-80 md:w-96 p-6">
                                                <div class="flex flex-col items-center mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-16 w-16 text-red-600 mb-2" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 9v2m0 4h.01M4.93 19h14.14c1.1 0 1.75-1.18 1.25-2.09l-7.07-12.17a1.5 1.5 0 00-2.56 0L3.68 16.91c-.5.91.14 2.09 1.25 2.09z" />
                                                    </svg>
                                                    <h2 class="text-xl font-bold text-gray-800">Confirm Deletion</h2>
                                                </div>
                                                <p class="text-gray-600 mb-6 text-center">Are you sure you want to delete
                                                    this Event?</p>
                                                <div class="flex justify-end space-x-2">
                                                    <button @click="$refs.deleteModal.classList.add('hidden')"
                                                        class="px-2 py-2 md:px-6 md:py-3 bg-orange-300 text-white rounded hover:bg-orange-400">Cancel</button>
                                                    <form action="{{ route('events.destroy', $event) }}" method="POST"
                                                        onsubmit="return confirm('Delete this event?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2 py-2 md:px-6 md:py-3 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="p-8 text-center text-gray-500 text-lg">No events found. Click "Add Event" to get started.</p>
        @endif
    </div>

    <!-- Modal -->
    <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center p-2 sm:p-0">
        <div class="bg-white rounded-xl p-4 sm:p-6 w-full sm:max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg sm:text-xl font-bold text-green-600">Add Event</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <form id="eventForm" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" id="methodField" name="_method" value="POST">
                <div>
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" id="title" name="title"
                        class="border rounded-md p-2 w-full text-sm sm:text-base" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea id="description" name="description" class="border rounded-md p-2 w-full text-sm sm:text-base"></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="border rounded-md p-2 w-full"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="border rounded-md p-2 w-full"
                            required>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="border rounded-md p-2 w-full"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="border rounded-md p-2 w-full"
                            required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Location</label>
                    <input type="text" id="location" name="location" class="border rounded-md p-2 w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Organizer</label>
                    <input type="text" id="organizer" name="organizer" class="border rounded-md p-2 w-full">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal()"
                        class="px-3 py-1 rounded-md bg-orange-400 text-white hover:bg-orange-500 transition text-sm sm:text-base">
                        Cancel
                    </button>
                    <button type="submit" id="saveBtn"
                        class="px-4 py-1 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition text-sm sm:text-base">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!--- View --->
    {{-- Event Detail Modal --}}
    <div id="eventDetailModal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50 p-2">
        <div
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative overflow-hidden transform transition-all duration-300">

            <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4 flex justify-between items-center">
                <h3 id="detailTitle" class="text-xl font-bold text-white flex items-center gap-2">
                </h3>
                <button type="button" onclick="closeEventDetailModal()"
                    class="text-white hover:text-gray-200 transition">
                    ✕
                </button>
            </div>

            <div class="p-6 space-y-5 text-gray-700">

                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p><span class="font-semibold mr-2">Date: </span> <span id="detailDate"></span></p>
                </div>

                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p><span class="font-semibold mr-2">Time: </span> <span id="detailTime"></span></p>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zm4.95 2.45a2.5 2.5 0 100 5 2.5 2.5 0 000-5z"
                            clip-rule="evenodd" />
                    </svg>
                    <p><span class="font-semibold mr-2">Location:</span> <span id="detailLocation"></span></p>
                </div>

                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p><span class="font-semibold mr-2">Organizer: </span> <span id="detailOrganizer"></span></p>
                </div>

                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6M9 8h6m2-6H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2z" />
                        </svg>
                        <span class="font-semibold">Description:</span>
                    </div>
                    <p id="detailDescription"
                        class="whitespace-pre-wrap p-3 rounded-lg bg-gray-100 border text-sm text-gray-600">
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            resetForm();
            document.getElementById('modalTitle').innerText = 'Create Event';
            document.getElementById('eventForm').action = "{{ route('events.store') }}";
            document.getElementById('methodField').value = "POST";
            document.getElementById('eventModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        function resetForm() {
            document.getElementById('eventForm').reset();
        }

        function editEvent(id) {
            fetch(`/newEvent/${id}/json`)
                .then(res => res.json())
                .then(event => {
                    document.getElementById('modalTitle').innerText = 'Edit Event';
                    document.getElementById('eventForm').action = `/newEvent/${id}`;
                    document.getElementById('methodField').value = "PUT";
                    document.getElementById('title').value = event.title ?? '';
                    document.getElementById('description').value = event.description ?? '';
                    document.getElementById('start_date').value = event.start_date ?? '';
                    document.getElementById('end_date').value = event.end_date ?? '';
                    document.getElementById('start_time').value = event.start_time ?? '';
                    document.getElementById('end_time').value = event.end_time ?? '';
                    document.getElementById('location').value = event.location ?? '';
                    document.getElementById('organizer').value = event.organizer ?? '';
                    document.getElementById('eventModal').classList.remove('hidden');
                });
        }

        function openEventDetailModal(event) {
            function formatDateWithDay(dateStr) {
                if (!dateStr) return '';
                const d = new Date(dateStr);

                const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                const dayName = days[d.getDay()];

                const day = String(d.getDate()).padStart(2, '0');
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const year = d.getFullYear();

                return `${dayName}, ${day}-${month}-${year}`;
            }

            function formatTimeAMPM(time24) {
                if (!time24) return '';
                const [hour, minute] = time24.split(':');
                let h = parseInt(hour);
                const ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12 || 12;
                return `${h}:${minute} ${ampm}`;
            }

            // Title
            document.getElementById('detailTitle').innerText = truncateText(event.title, 0, 40);

            // Date (with weekday)
            if (event.start_date && event.end_date) {
                if (event.start_date === event.end_date) {
                    document.getElementById('detailDate').innerText = formatDateWithDay(event.start_date);
                } else {
                    document.getElementById('detailDate').innerText =
                        `${formatDateWithDay(event.start_date)} → ${formatDateWithDay(event.end_date)}`;
                }
            } else {
                document.getElementById('detailDate').innerText = 'N/A';
            }

            // Time
            const startTime = event.start_time ? formatTimeAMPM(event.start_time) : '';
            const endTime = event.end_time ? formatTimeAMPM(event.end_time) : '';
            document.getElementById('detailTime').innerText =
                startTime && endTime ? `${startTime} - ${endTime}` : (startTime || endTime || 'N/A');

            // Other fields
            document.getElementById('detailLocation').innerText = event.location || 'N/A';
            document.getElementById('detailOrganizer').innerText = event.organizer || 'N/A';
            document.getElementById('detailDescription').innerText = event.description || 'No description';

            // Show modal
            document.getElementById('eventDetailModal').classList.remove('hidden');
        }

        function closeEventDetailModal() {
            document.getElementById('eventDetailModal').classList.add('hidden');
        }
        function truncateText(text, start, end) {
            if (!text) return '';
            return text.length > end ? text.substring(start, end) + '...' : text;
        }
    </script>

@endsection
