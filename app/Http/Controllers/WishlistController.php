<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Game;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlists = Wishlist::where([
            ['user_id', auth()->id()],
            ['deleted', false],
        ]);
        if ($request->has('query')) {
            $wishlists = $wishlists->where('name', 'ilike', '%' . $request->input('query') . '%');
        }
        return view('wishlists.index', [
            'wishlists' => $wishlists->orderBy('bought')->orderBy('name')->get(),
        ]);
    }

    public function show(Request $request, $wishlist_id) {
        $wishlist = Wishlist::find($wishlist_id);
        if ($wishlist->deleted == true) {
            return redirect('wishlists');
        } else {
            $games = Game::where([
                ['wishlist_id', $wishlist_id],
                ['deleted', false],
            ]);
            if ($request->has('query')) {
                $games = $games->where('name', 'ilike', '%' . $request->input('query') . "%");
            }
            return view('wishlists.show', [
                'wishlist' => $wishlist,
                'games' => $games->orderBy('order')->orderBy('bought')->orderBy('name')->get(),
            ]);
        }
    }

    public function delete($wishlist_id)
    {
        $wishlist = Wishlist::find($wishlist_id);
        if ($wishlist->user_id == auth()->id()) {
            $wishlist->update(['deleted' => true]);
        }
        return redirect()->route('wishlists.index');
    }
}
