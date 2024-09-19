<?php

namespace App\Http\Controllers;

use App\Events\BidPlaced;
use App\Jobs\EmitBidEvent;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing bids.
 * Handles actions like placing a bid and listing bids for an auction.
 */
class BidController extends Controller
{
    /**
     * Centralized method to place a bid
     */
    public function placeBid($auctionId, $amount, $userId)
    {
        $user = Auth::user();

        // // Find the auction
        $auction = Auction::find($auctionId);
        if (!$auction) {
            return response()->json(['error' => 'Auction not found.'], 404);
        }

        // Ensure the auction is active
        if ($auction->status !== 'active') {
            return response()->json(['error' => 'The auction is not active.'], 400);
        }

        // Ensure the bid is higher than the current price
        if ($amount <= $auction->current_price) {
            return response()->json(['error' => 'Bid amount must be higher than the current price.'], 400);
        }

        // Create the bid
        $bid = Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $user->id,
            'amount' => $amount,
        ]);

        // Update auction's current price
        $auction->current_price = $amount;

        // Extend grace period if applicable
        $auction->extendGracePeriod();
        $auction->save();

        // Dispatch the job to handle the event emission
        // EmitBidEvent::dispatch($bid);
        event(new BidPlaced($bid));

        // return ['auction' => $auction, 'bid' => $bid];
        return response()->json(['message' => 'We are now here.', 'user' => $user, 'auction' => $auction, 'bid' => $bid], 201);
    }

    /**
     * HTTP API Endpoint for placing a bid.
     */
    public function store(Request $request)
    {
        $request->validate([
            'auction_id' => 'required|exists:auctions,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $auctionId = $request->auction_id;
        $amount = $request->amount;
        $userId = Auth::id();

        return $this->placeBid($auctionId, $amount, $userId);
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
