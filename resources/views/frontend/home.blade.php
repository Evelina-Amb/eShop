@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">

    <h1 class="text-3xl font-bold mb-6">Naujausi skelbimai</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($listings as $item)
            <div class="border rounded-lg shadow p-4 hover:shadow-lg transition">
                <img 
                    src="{{ $item['photo_url'] ?? 'https://via.placeholder.com/300' }}" 
                    alt="" 
                    class="w-full h-40 object-cover rounded"
                >

                <h2 class="text-xl font-semibold mt-2">
                    {{ $item['title'] }}
                </h2>

                <p class="text-gray-600 text-sm">{{ $item['description'] }}</p>

                <div class="flex justify-between items-center mt-3">
                    <span class="font-bold text-green-600">{{ $item['price'] }} €</span>
                    <a href="/listing/{{ $item['id'] }}" class="text-blue-600">Plačiau →</a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
