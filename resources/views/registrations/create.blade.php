@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-xl font-bold mb-4">Register for: {{ $event->title }}</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('events.register.store', $event->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block">Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Gender</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">Select</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block">Phone</label>
                <input type="text" name="phone" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block">Organization</label>
                <input type="text" name="organization" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Register
            </button>
        </form>
    </div>
@endsection
