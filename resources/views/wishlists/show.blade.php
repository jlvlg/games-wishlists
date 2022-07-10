<x-app-layout>
    <x-slot name="header">
        <a href="{{route('wishlists.show', ['id' => $wishlist->id])}}" class="self-center font-semibold text-xl text-gray-400 leading-tight truncate">
            {{$wishlist->name}}
        </a>
        <form :action="route('wishlists.index')" class="flex items-center flex-1 rounded-lg bg-gray-800 text-gray-400 border border-gray-500 mx-5" method="get">
            <label for="search" hidden>Search games</label>
            <input type="search" class="flex-1 border-none bg-transparent focus:border-none focus:ring-none" name="q" id="search" placeholder="Search games" value={{(request()->has('q')) ? request()->input('q') : ''}}>
            <button class="mr-3 {{(request()->filled('q')) ? 'hidden' : ''}}" action="submit"><svg width="24" class="fill-gray-400" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M15.853 16.56c-1.683 1.517-3.911 2.44-6.353 2.44-5.243 0-9.5-4.257-9.5-9.5s4.257-9.5 9.5-9.5 9.5 4.257 9.5 9.5c0 2.442-.923 4.67-2.44 6.353l7.44 7.44-.707.707-7.44-7.44zm-6.353-15.56c4.691 0 8.5 3.809 8.5 8.5s-3.809 8.5-8.5 8.5-8.5-3.809-8.5-8.5 3.809-8.5 8.5-8.5z"/></svg></button>
            <a class="mr-3 {{(request()->filled('q')) ? '' : 'hidden'}}" href="{{route('wishlists.show', ['id' => $wishlist->id])}}"><svg class="fill-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/></svg></a>
        </form>
        <div class="flex gap-2">
            <x-button-link class="py-3 bg-gray-700 hover:bg-gray-600 focus:bg-gray-500 transition text-gray-400 text-xl flex-none" :href="route('games.create', ['wishlist_id' => $wishlist->id])">
                Add
            </x-button-link>
            <x-button-link class="py-3 bg-gray-700 hover:bg-gray-600 focus:bg-gray-500 transition text-gray-400 text-xl flex-none" :href="route('wishlists.edit', ['id' => $wishlist->id])">
                Edit
            </x-button-link>
            <x-button-link class="py-3 bg-red-800 hover:bg-red-700 focus:bg-red-600 transition text-gray-400 text-xl flex-none" :href="route('wishlists.delete', ['id' => $wishlist->id])">
                Delete
            </x-button-link>
        </div>
    </x-slot>

    <div class='text-gray-400'>
        @foreach ($games as $game)
            <div class='flex gap-2 my-3 mx-5'>
                <x-button-link class='flex flex-1 bg-gray-700 hover:bg-gray-600 focus:bg-gray-500 transition text-xl max-w-full truncate' :href="route('games.show', ['id' => $game->id])">
                    <span class="{{$game->bought ? 'line-through italic' : ''}}">{{$game->name}}</span>
                    <span class='flex flex-1 justify-end'>R$ {{number_format($game->price, 2)}}</span>
                </x-button-link>
                <x-button-link class='flex-none bg-yellow-700 hover:bg-yellow-600 focus:bg-yellow-500 transition' :href="route('games.bought', ['id' => $game->id])">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm1 16.947v1.053h-1v-.998c-1.035-.018-2.106-.265-3-.727l.455-1.644c.956.371 2.229.765 3.225.54 1.149-.26 1.384-1.442.114-2.011-.931-.434-3.778-.805-3.778-3.243 0-1.363 1.039-2.583 2.984-2.85v-1.067h1v1.018c.724.019 1.536.145 2.442.42l-.362 1.647c-.768-.27-1.617-.515-2.443-.465-1.489.087-1.62 1.376-.581 1.916 1.712.805 3.944 1.402 3.944 3.547.002 1.718-1.343 2.632-3 2.864z"/></svg>
                </x-button-link>
                <x-button-link class='flex-none bg-sky-800 hover:bg-sky-700 focus:bg-sky-600 transition' :href="route('games.edit', ['id' => $game->id])">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.127 22.564l-7.126 1.436 1.438-7.125 5.688 5.689zm-4.274-7.104l5.688 5.689 15.46-15.46-5.689-5.689-15.459 15.46z"/></svg>
                </x-button-link>
                <x-button-link class='flex-none bg-red-800 hover:bg-red-700 focus:bg-red-600 transition' :href="route('games.delete', ['id' => $game->id])">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M19 24h-14c-1.104 0-2-.896-2-2v-16h18v16c0 1.104-.896 2-2 2m-9-14c0-.552-.448-1-1-1s-1 .448-1 1v9c0 .552.448 1 1 1s1-.448 1-1v-9zm6 0c0-.552-.448-1-1-1s-1 .448-1 1v9c0 .552.448 1 1 1s1-.448 1-1v-9zm6-5h-20v-2h6v-1.5c0-.827.673-1.5 1.5-1.5h5c.825 0 1.5.671 1.5 1.5v1.5h6v2zm-12-2h4v-1h-4v1z"/></svg>
                </x-button-link>
            </div>
        @endforeach
    </div>
</x-app-layout>
