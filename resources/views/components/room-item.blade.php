<a href="{{ route('rooms.show', $room) }}">
    <div class="p-6 text-gray-900 font-bold hover:bg-gray-100">
        {{ $room->name }} ({{ $room->members_count }})
    </div>
</a>
