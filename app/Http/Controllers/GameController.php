<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Game;
use \App\Models\Wishlist;

class GameController extends Controller
{
    public function show(Request $request) {
        $game = Game::find($request->id);

        if ($game->deleted) {
            return redirect()->route('wishlists.show', ['id' => $game->wishlist_id]);
        } else {
            if ($game->auto) {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.isthereanydeal.com/v01/game/overview/?key=14de5fca49a0f9dc539816b40fdbcec3c591baf6&region=br2&country=BR&shop=steam&ids=' . $game->store_id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                $response = json_decode(curl_exec($ch));
                curl_close($ch);

                if (isset($response->data->{$game->store_id}->price)) {
                    $price = $response->data->{$game->store_id}->price;

                    $game->update([
                        'store' => $price->store,
                        'price' => $price->price,
                        'url' => $price->url,
                    ]);
                } else {
                    $game->update([
                        'store' => 'Not found',
                        'price' => 0,
                        'url' => route('games.show', ['id' => $game->id]),
                    ]);
                }
            } else {
                $game->update([
                    'store' => 'none',
                ]);
            }

            return view('games.show', compact('game'));
        }
    }

    public function edit(Request $request) {
        $game = Game::find($request->id);
        if ($game->deleted || $game->wishlist->user_id != auth()->id()) {
            return redirect()->route('wishlists.show', ['id' => $game->wishlist_id]);
        } else {
            return view('games.edit', compact('game'));
        }
    }

    public function create(Request $request) {
        $wishlist = Wishlist::find($request->wishlist_id);
        if ($wishlist->deleted || $wishlist->user_id == auth()->id()) {
            return view('games.create', compact('wishlist'));
        } else {
            return redirect()->route('wishlists.index');
        }
    }

    private function check_wishlist_bought($wishlist_id) {
        $wishlist = Wishlist::find($wishlist_id);
        $wishlist->update(['bought' => !in_array(false, $wishlist->games->where('deleted', false)->pluck('bought')->toArray())]);
    }

    public function bought(Request $request) {
        $game = Game::find($request->id);
        $game->update([
            'bought' => !$game->bought,
        ]);
        $this->check_wishlist_bought($game->wishlist_id);
        return redirect()->route('wishlists.show', ['id' => $game->wishlist_id]);
    }

    public function update(Request $request) {
        $game = Game::find($request->id);
        if ($game->wishlist->user_id == auth()->id()) {
            $game->update($request->all());
            $this->check_wishlist_bought($game->wishlist_id);
        }
        return redirect()->route('games.show', ['id' => $game->id]);
    }

    public function store(Request $request) {
        $game = Game::create($request->all());
        $this->check_wishlist_bought($game->wishlist_id);
        return redirect()->route('wishlists.show', ['id' => $game->wishlist_id]);
    }

    public function delete(Request $request) {
        $game = Game::find($request->id);
        if ($game->wishlist->user_id == auth()->id()) {
            $game->update(['deleted' => true]);
        }
        return redirect()->route('wishlists.show', ['id' => $game->wishlist->id]);
    }
}
