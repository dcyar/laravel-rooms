<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $room->name }}
            </h2>
            @if(! $room->canAccess(auth()->id()))
                <x-link :href="route('rooms.join', $room)">Join</x-link>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        @if($room->canAccess(auth()->id()))
            <div x-data="room({{ $room->messages }})" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-2">
                    <template x-for="user in roomUsers" :key="user.id">
                        <span class="text-xs text-slate-700 border rounded-md bg-orange-200 py-1 px-2 mr-1" x-text="user.email"></span>
                    </template>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y-2">
                    <template x-for="message in messages" :key="message.id">
                        <div class="p-6 text-gray-900">
                            <h5 x-text="message.user.name" class="text-xs"></h5>
                            <p x-text="message.message" class="text-slate-500"></p>
                        </div>
                    </template>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 font-bold">
                        <form @submit.prevent="sendMessage" action="{{ route('rooms.message.store') }}" method="post">
                            <div>
                                <input name="message" x-model="message" type="text" class="font-normal block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="flex justify-end">
                                <x-primary-button class="mt-3">
                                    {{ __('Send') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y-2">
                    <div class="p-6 text-gray-600">
                        <p>No estas tienes permisos para ver los mensajes de esta sala.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <x-slot name="scripts">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('room', (messages) => ({
                    messages: messages,
                    message: '',
                    roomUsers: [],
                    init() {
                        Echo.join('room.{{ $room->id }}')
                            .here(users => {
                                this.roomUsers = [...users];
                            })
                            .joining(user => {
                                this.roomUsers = [user, ...this.roomUsers]
                            })
                            .leaving(user => {
                                this.roomUsers = this.roomUsers.filter(usr => usr.id !== user.id)
                            })
                            .listen('RoomMessageSent', ({ roomMessage}) => {
                                this.messages = [roomMessage, ...this.messages];
                            })
                            .error(err => console.log(err))
                    },
                    async sendMessage({ target }) {
                        const { data } = await axios.post(target.action, {
                            room_id: {{ $room->id }},
                            message: this.message,
                        });

                        this.messages = [data.data, ...this.messages];
                        this.message = ''
                    }
                }))
            })
        </script>
    </x-slot>
</x-app-layout>
