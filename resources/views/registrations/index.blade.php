@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-6 bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4">Registrations for {{ $event->title }}</h2>

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-3 py-2">#</th>
                <th class="border px-3 py-2">Name</th>
                <th class="border px-3 py-2">Email</th>
                <th class="border px-3 py-2">Phone</th>
                <th class="border px-3 py-2">Organization</th>
                <th class="border px-3 py-2">Registered At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $i => $reg)
                <tr>
                    <td class="border px-3 py-2">{{ $i+1 }}</td>
                    <td class="border px-3 py-2">{{ $reg->name }}</td>
                    <td class="border px-3 py-2">{{ $reg->email }}</td>
                    <td class="border px-3 py-2">{{ $reg->phone }}</td>
                    <td class="border px-3 py-2">{{ $reg->organization }}</td>
                    <td class="border px-3 py-2">{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
