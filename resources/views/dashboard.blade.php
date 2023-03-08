<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($rooms as $room)
                    <a href="{{ route('rooms.show', $room) }}">
                        <div class="p-6 text-gray-900 font-bold hover:bg-gray-100">
                            {{ $room->name }} - <small class="text-xs font-light">{{ $room->owner->name }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('load', () => {
            Echo.channel('things')
                .listen('NewThingAvailable', (event) => {
                    alert(event.message)
                });

            Echo.private('App.Models.User.{{ auth()->id() }}')
                .listen('OrderDispatched', (e) => {
                    alert(`Your product for ${e.order.amount} was delivered!!`)
                })
        });
    </script>
</x-app-layout>
