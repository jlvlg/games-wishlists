<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        return view('wishlists.index', [
            'wishlists' => Wishlist::where('deleted', false)
                ->where('user_id', auth()->id())
                ->get(),
        ]);
    }
}
