<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\FavoriteAuction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteAuctionController extends Controller
{
    // Set an auction as favorite
    public function set(Request $request)
    {
        $user = Auth::user();
        $auction = Auction::where('hash', $request->auctionHash)->firstOrFail();

        $favorite = FavoriteAuction::firstOrCreate(
            ['user_id' => $user->id, 'auction_id' => $auction->id],
            ['first_favorited' => now()]
        );

        return response()->json(['message' => 'Auction favorited successfully', 'favorite' => $favorite]);
    }

    // Unset an auction from favorites
    public function unset(Request $request)
    {
        $user = Auth::user();
        $auction = Auction::where('hash', $request->auctionHash)->firstOrFail();

        $favorite = FavoriteAuction::where('user_id', $user->id)
            ->where('auction_id', $auction->id)
            ->first();

        if ($favorite) {
            $favorite->update(['last_unfavorited' => now()]);
            return response()->json(['message' => 'Auction unfavorited successfully']);
        }

        return response()->json(['message' => 'Auction not found in favorites'], 404);
    }

    public static function getUserFavorites()
    {
        $user = Auth::user();
        return FavoriteAuction::where('user_id', $user->id)->with('auction')->get()->map(function ($favorite) {
            $auction = $favorite->auction;
            
            // Bids
            $auction->load('bids');

            $auction->favorite = true;

            return $auction;
        });
    }
}
