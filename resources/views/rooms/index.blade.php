<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Rooms') }}
            </h2>
            <x-link :href="route('rooms.create')" class="ml-3">
                {{ __('Create Room') }}
            </x-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($rooms as $room)
                    <x-room-item :room="$room" />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
