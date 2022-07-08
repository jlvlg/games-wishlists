<x-app-layout>
    <x-slot name="header">
        <a class="flex gap-2 flex-1 self-center font-semibold text-xl text-gray-400 leading-tight truncate" href="{{route('games.show', ['id' => $game->id])}}">
            <svg class="fill-gray-400" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
            {{$game->name}}
        </a>
        <div class="flex gap-2">
            <x-button-link class="py-3 bg-red-800 hover:bg-red-700 focus:bg-red-600 transition text-gray-400 text-xl flex-none" :href="route('games.delete', ['id' => $game->id])">
                Delete
            </x-button-link>
        </div>
    </x-slot>

    <div class='text-gray-400 bg-gray-700 rounded-xl m-5 p-5'>
        <form action="{{route('games.update')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$game->id}}">
            <input type="hidden" name="store" value="{{$game->store}}">
            <div class="flex mb-3 gap-3">
                <input required class="flex-1 bg-gray-800 border border-gray-500 rounded-lg truncate" value="{{$game->name}}" type="text" name="name" id="name">
                <select class="bg-gray-800 rounded-lg border border-gray-500" name="bought">
                    <option selected value="{{($game->bought) ? 1 : 0}}">{{($game->bought) ? 'Bought' : 'Not Bought'}}</option>
                    <option value="{{!($game->bought) ? 1 : 0}}">{{!($game->bought) ? 'Bought' : 'Not Bought'}}</option>
                </select>
            </div>
            <div class="flex mb-3 gap-3">
                <select class="flex-none bg-gray-800 border border-gray-500 rounded-lg" name="auto">
                    <option selected value="{{($game->auto) ? 1 : 0}}">{{($game->auto) ? 'Auto price' : 'Manual price'}}</option>
                    <option value="{{!($game->auto) ? 1 : 0}}">{{!($game->auto) ? 'Auto price' : 'Manual price'}}</option>
                </select>
                <div class="flex bg-gray-800 border border-gray-500 w-fit rounded-lg pl-3 items-center">
                    R$ <input required class="w-24 bg-transparent border-none" value="{{number_format($game->price, 2)}}" type="text" name="price" id="price">
                </div>
                <input required class="flex-1 bg-gray-800 border border-gray-500 rounded-lg px-5" value="{{$game->url}}" type="text" name="url" id="url">
                <input required class="flex-none bg-gray-800 border border-gray-500 rounded-lg w-14 text-center" value="{{$game->order}}" type="text" name="order" id="order">
            </div>
            <div class="flex">
                <input class="flex-1 text-white bg-sky-600 hover:bg-sky-500 focus:bg-sky-400 transition rounded-lg p-2" type="submit" value="Save">
            </div>
        </form>
    </div>
</x-app-layout>
