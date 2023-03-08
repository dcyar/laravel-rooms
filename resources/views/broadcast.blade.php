<x-guest-layout>
    <form action="/broadcast" method="post">
        @csrf
        <div>
            <x-input-label for="message" :value="__('Message')" />
            <x-text-input id="message" class="block mt-1 w-full" type="text" name="message" :value="old('message')" required autofocus autocomplete="message" />
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
        </div>
        <x-primary-button class="w-full py-3 mt-3">
            {{ __('Send') }}
        </x-primary-button>
    </form>
</x-guest-layout>
