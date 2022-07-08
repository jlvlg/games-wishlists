<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Game;
use \App\Models\Wishlist;

class GameController extends Controller
{
    public function show($game_id) {
        $game = Game::find($game_id);

        if ($game->auto) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://api.isthereanydeal.com/v02/game/plain/?key=14de5fca49a0f9dc539816b40fdbcec3c591baf6&title=" . $game->name);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            $game_plain = json_decode(curl_exec($ch));

            if (isset($game_plain->data->plain)) {
                $game_plain = $game_plain->data->plain;
                curl_setopt($ch, CURLOPT_URL, "https://api.isthereanydeal.com/v01/game/prices/?key=14de5fca49a0f9dc539816b40fdbcec3c591baf6&region=br2&country=BR&plains=" . $game_plain);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                $game_prices = json_decode(curl_exec($ch))->data->$game_plain->list;
                if (count($game_prices)) {
                    $game->update([
                        'price' => $game_prices[0]->price_new,
                        'url' => $game_prices[0]->url,
                        'store' => $game_prices[0]->shop->name,
                    ]);
                } else {
                    $game->update([
                        'price' => 0,
                        'url' => 'Not found, try changing the title',
                        'store' => 'none',
                    ]);
                }
            } else {
                $game->update([
                    'price' => 0,
                    'url' => 'Not found, try changing the title',
                    'store' => 'none',
                ]);
            }
            curl_close($ch);
        }

        return view('games.show', compact('game'));
    }

    public function edit($game_id) {
        $game = Game::find($game_id);
        return view('games.edit', compact('game'));
    }

    public function create(Request $request) {
        $wishlist = Wishlist::find($request->input('wishlist_id'));
        if ($wishlist->user_id == auth()->id()) {
            return view('games.create', compact('wishlist'));
        } else {
            return redirect()->route('wishlists.index');
        }
    }

    private function alternate_bought($game_id) {
        $game = Game::find($game_id);
        $game->update(['bought' => !$game->bought]);
        $game->wishlist->update(['bought' => !in_array(false, $game->wishlist->games->where('deleted', false)->pluck('bought')->toArray())]);
    }

    public function bought($game_id) {
        $this->alternate_bought($game_id);
        return redirect()->route('wishlists.show', ['id' => Game::find($game_id)->wishlist_id]);
    }

    public function update(Request $request) {
        $game = Game::find($request->id);
        if ($game->wishlist->user_id == auth()->id()) {
            if ($game->bought != $request->bought) {
                $this->alternate_bought($game->id);
            }
            $game->update($request->all());
        }
        return redirect()->route('games.show', ['id' => $game->id]);
    }

    public function store(Request $request) {
        $game = Game::create($request->all());
        $game->save();
        return redirect()->route('wishlists.show', ['id' => $game->wishlist_id]);
    }

    public function delete($game_id) {
        $game = Game::find($game_id);
        if ($game->wishlist->user_id == auth()->id()) {
            $game->update(['deleted' => true]);
        }
        return redirect()->route('wishlists.show', ['id' => $game->wishlist->id]);
    }
}
