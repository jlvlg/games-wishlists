<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight">
            {{ __('Wishlists') }}
        </h2>
    </x-slot>

    @foreach ($wishlists as $wishlist)
        <x-list-item class="text-xl">
            {{ $wishlist->name }}
        </x-list-item>
    @endforeach
</x-app-layout>
