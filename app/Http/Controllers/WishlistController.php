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
        if ($request->has('q')) {
            $wishlists = $wishlists->where('name', 'ilike', '%' . $request->q . '%');
        }
        return view('wishlists.index', [
            'wishlists' => $wishlists->orderBy('bought')->orderBy('name')->get(),
        ]);
    }

    public function show(Request $request) {
        $wishlist = Wishlist::find($request->id);
        if ($wishlist->deleted) {
            return redirect()->route('wishlists.index');
        } else {
            $games = Game::where([
                ['wishlist_id', $wishlist->id],
                ['deleted', false],
            ]);
            if ($request->has('q')) {
                $games = $games->where('name', 'ilike', '%' . $request->q . "%");
            }

            $return = $games->orderBy('bought')->orderBy('price')->orderBy('name')->get();

            $games_auto = $games->where('auto', true);

            if (count($games_auto->get())) {
                $prices = $this->fetch_prices($games_auto->pluck('store_id')->toArray());
                foreach ($games_auto->get() as $game) {
                    if (isset($prices->{$game->store_id}->price->price)) {
                        $game->update([
                            'price' => $prices->{$game->store_id}->price->price,
                        ]);
                    } else {
                        $game->update([
                            'price' => 0,
                        ]);
                    }
                }
            }

            return view('wishlists.show', [
                'wishlist' => $wishlist,
                'games' => $return,
            ]);
        }
    }

    public function fetch_prices($game_ids) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.isthereanydeal.com/v01/game/overview/?key=14de5fca49a0f9dc539816b40fdbcec3c591baf6&region=br2&country=BR&shop=steam&ids=' . implode(',', $game_ids));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        return $response->data;
    }

    public function edit(Request $request) {
        $wishlist = Wishlist::find($request->id);
        if ($wishlist->deleted || $wishlist->user_id != auth()->id()) {
            return redirect()->route('wishlists.index');
        } else {
            return view('wishlists.edit', compact('wishlist'));
        }
    }

    public function update(Request $request) {
        $wishlist = Wishlist::find($request->id);
        if ($wishlist->deleted || $wishlist->user_id != auth()->id()) {
            return redirect()->route('wishlists.index');
        } else {
            $wishlist->update($request->all());
            return redirect()->route('wishlists.show', ['id' => $wishlist->id]);
        }
    }

    public function create() {
        return view('wishlists.create');
    }

    public function store(Request $request) {
        $wishlist = Wishlist::create($request->all());
        return redirect()->route('wishlists.show', ['id' => $wishlist->id]);
    }

    public function delete(Request $request)
    {
        $wishlist = Wishlist::find($request->id);
        if ($wishlist->user_id == auth()->id()) {
            $wishlist->update(['deleted' => true]);
        }
        foreach ($wishlist->games as $game) {
            $game->update(['deleted' => true]);
        }
        return redirect()->route('wishlists.index');
    }
}
