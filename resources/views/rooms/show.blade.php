<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div x-data="room({{ $room->messages }})" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
    </div>
    <x-slot name="scripts">
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('room', (messages) => ({
                    messages: messages,
                    message: '',
                    async sendMessage({ target }) {
                        const response = await fetch(target.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                _token: '{{ csrf_token() }}',
                                room_id: {{ $room->id }},
                                message: this.message,
                            }),
                        });

                        const { data } = await response.json();

                        this.messages = [data, ...this.messages];
                    }
                }))
            })
        </script>
    </x-slot>
</x-app-layout>
