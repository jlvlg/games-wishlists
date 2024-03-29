<x-app-layout>
    <x-slot name="header">
        <a class="flex gap-2 flex-1 self-center font-semibold text-xl text-gray-400 leading-tight truncate" href="{{route('wishlists.show', ['id' => $game->wishlist->id])}}">
            <svg class="fill-gray-400" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
            {{$game->wishlist->name}}
        </a>
        <div class="flex gap-2">
            <x-button-link class="py-3 bg-gray-700 hover:bg-gray-600 focus:bg-gray-500 transition text-gray-400 text-xl flex-none" :href="route('games.edit', ['id' => $game->id])">
                Edit
            </x-button-link>
            <x-button-link class="py-3 bg-red-800 hover:bg-red-700 focus:bg-red-600 transition text-gray-400 text-xl flex-none" :href="route('games.delete', ['id' => $game->id])">
                Delete
            </x-button-link>
        </div>
    </x-slot>

    <form class='text-gray-400 bg-gray-700 rounded-xl m-5 p-5' action="{{route('games.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$game->id}}">
        <input type="hidden" name="bought" value="{{!($game->bought) ? 1 : 0}}">
        <div class="flex mb-3 gap-3">
            <div class="flex items-center flex-1 bg-gray-800 border border-gray-500 rounded-lg px-3 truncate">{{$game->name}}</div>
            <button class="flex-none bg-gray-800 hover:bg-gray-700 focus:bg-gray-600 transition border border-gray-500 rounded-lg p-2" type="submit">{{$game->bought ? 'Bought' : 'Not bought'}}</button>
        </div>
        <div class="flex gap-3">
            <div class="flex bg-gray-800 border border-gray-500 rounded-lg pl-3 items-center">
                R$ <span class="flex items-center justify-center w-24 bg-transparent border-none">{{number_format($game->price, 2, '.', '')}}</span>
            </div>
            <a class="flex items-center px-5 flex-1 bg-gray-800 border border-gray-500 rounded-lg p-2" href="{{$game->url}}">{{($game->store == 'none') ? $game->url : $game->store}}</a>
        </div>
    </form>
</x-app-layout>
