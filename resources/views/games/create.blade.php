<x-app-layout>
    <x-slot name="header">
        <a class="flex gap-2 flex-1 self-center font-semibold text-xl text-gray-400 leading-tight truncate" href="{{route('wishlists.show', ['id' => $wishlist->id])}}">
            <svg class="fill-gray-400" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
            {{$wishlist->name}}
        </a>
    </x-slot>

    <div class='text-gray-400 bg-gray-700 rounded-xl m-5 p-5'>
        <form action="{{route('games.store')}}" method="post">
            @csrf
            <div class="flex mb-3 gap-3">
                <input type="hidden" name="wishlist_id" value="{{$wishlist->id}}">
                <input type="hidden" name="store" value="none">
                <input type="hidden" name="deleted" value="false">
                <input required class="flex-1 bg-gray-800 border border-gray-500 rounded-lg truncate" placeholder="Game title" type="text" name="name" id="name">
                <select class="bg-gray-800 rounded-lg border border-gray-500" name="bought">
                    <option selected value="0">Not bought</option>
                    <option value="1">Bought</option>
                </select>
            </div>
            <div class="flex mb-3 gap-3">
                <select class="flex-none bg-gray-800 border border-gray-500 rounded-lg" name="auto">
                    <option selected value="1">Auto price</option>
                    <option value="0">Manual price</option>
                </select>
                <div class="flex bg-gray-800 border border-gray-500 w-fit rounded-lg pl-3 items-center">
                    R$ <input required class="w-24 bg-transparent border-none" value="0.00" type="text" name="price" id="price">
                </div>
                <input required class="flex-1 bg-gray-800 border border-gray-500 rounded-lg px-5" value="URL" type="text" name="url" id="url">
                <input required class="flex-none bg-gray-800 border border-gray-500 rounded-lg w-14 text-center" placeholder="Ord" type="text" name="order" id="order">
            </div>
            <div class="flex">
                <input class="flex-1 text-white bg-sky-600 hover:bg-sky-500 focus:bg-sky-400 transition rounded-lg p-2" type="submit" value="Create">
            </div>
        </form>
    </div>
</x-app-layout>
