<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing bids.
 * Handles actions like placing a bid and listing bids for an auction.
 */
class BidController extends Controller
{
    /**
     * Place a new bid on an auction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $auction = Auction::findOrFail($request->auction_id);

        // Authorization check
        $this->authorize('create', [Bid::class, $auction]);

        // Ensure auction is active and bid amount is valid
        if ($auction->status !== 'active') {
            return response()->json(['error' => 'Auction is not active.'], 400);
        }

        if ($request->amount <= $auction->current_price) {
            return response()->json(['error' => 'Bid amount must be higher than the current price.'], 400);
        }

        $user = Auth::user();

        $bid = Bid::create([
            'auction_id' => $request->auction_id,
            'user_id' => $user->id,
            'amount' => $request->amount,
        ]);

        // Update auction's current price
        $auction->current_price = $request->amount;
        $auction->save();

        return response()->json(['message' => 'Bid placed successfully.', 'bid' => $bid]);
    }

    /**
     * List all bids for a specific auction.
     */
    public function index($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        // Authorization check
        $this->authorize('viewAny', [Bid::class, $auction]);

        $bids = Bid::where('auction_id', $auctionId)->get();
        return response()->json($bids);
    }
}
