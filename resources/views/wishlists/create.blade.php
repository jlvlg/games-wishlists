<x-app-layout>
    <x-slot name="header">
        <a class="flex gap-2 flex-1 self-center font-semibold text-xl text-gray-400 leading-tight truncate" href="{{route('wishlists.index')}}">
            <svg class="fill-gray-400" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>
            Wishlists
        </a>
    </x-slot>

    <form class='text-gray-400 bg-gray-700 rounded-xl m-5 p-5' action="{{route('wishlists.store')}}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{auth()->id()}}">
        <input type="hidden" name="bought" value="true">
        <input type="hidden" name="deleted" value="false">
        <div class="flex mb-3 gap-3">
            <input required class="flex-1 bg-gray-800 border border-gray-500 rounded-lg truncate focus:border-gray-400 focus:ring-gray-400 transition" placeholder="Title" type="text" name="name" id="name">
        </div>
        <div class="flex">
            <input class="flex-1 text-white bg-sky-600 hover:bg-sky-500 focus:bg-sky-400 transition rounded-lg p-2" type="submit" value="Create">
        </div>
    </form>

</x-app-layout>
