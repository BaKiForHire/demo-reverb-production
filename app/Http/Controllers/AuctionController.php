<?php

namespace App\Http\Controllers;

use App\Enums\AuctionStatus;
use App\Models\Auction;
use App\Models\AuctionCategory;
use App\Models\Bid;
use App\Models\FavoriteAuction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for managing auctions.
 * Handles actions like listing, creating, updating, freezing, and deleting auctions.
 */
class AuctionController extends Controller
{
    /**
     * Display a listing of all active auctions.
     */
    public function index()
    {
        $auctions = Auction::where('status', AuctionStatus::ACTIVE->value)->get();
        return response()->json($auctions);
    }

    /**
     * Display the specified auction.
     */
    public function show($id)
    {
        $auction = Auction::with(['bids', 'categories'])->findOrFail($id);
        return response()->json($auction);
    }

    /**
     * Store a newly created auction in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Auction::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_price' => 'required|numeric|min:0',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'media_url' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:auction_categories,id',
            'location_id' => 'nullable|integer|exists:locations,id',
        ]);

        $user = Auth::user();

        // Allow "Use My Location" if user has a location
        $locationId = $request->input('location_id') ?? $user->location_id;

        $user = Auth::user();

        $auction = Auction::create($request->only(['title', 'description', 'start_price', 'start_time', 'end_time', 'media_url']) + [
            'user_id' => $user->id,
            'location_id' => $locationId,
            'status' => 'active',
            'current_price' => $request->input('start_price'),
        ]);

        // Attach categories if provided
        if ($request->has('categories')) {
            $auction->categories()->sync($request->input('categories'));
        }

        return response()->json(['message' => 'Auction created successfully.', 'auction' => $auction]);
    }

    /**
     * Store media for an auction.
     */
    public function storeMedia(Request $request, $auctionId)
    {
        $auction = Auction::findOrFail($auctionId);

        $request->validate([
            'media' => 'required|array',
            'media.*.url' => 'required|string', // For simplicity, assume URLs are being passed. Replace with file handling logic later.
            'media.*.media_type' => 'required|string|in:image,video,3D',
            'media.*.alt_text' => 'nullable|string',
        ]);

        foreach ($request->media as $mediaData) {
            $auction->media()->create($mediaData);
        }

        return response()->json(['message' => 'Media uploaded successfully.']);
    }


    /**
     * Update the specified auction in storage.
     */
    public function update(Request $request, $id)
    {
        $auction = Auction::findOrFail($id);
        $this->authorize('update', $auction);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_price' => 'sometimes|numeric|min:0',
            'start_time' => 'sometimes|date|after_or_equal:today',
            'end_time' => 'sometimes|date|after:start_time',
            'media_url' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:auction_categories,id',
        ]);

        $auction->update($request->only(['title', 'description', 'start_price', 'start_time', 'end_time', 'media_url']));

        // Update categories if provided
        if ($request->has('categories')) {
            $auction->categories()->sync($request->input('categories'));
        }

        return response()->json(['message' => 'Auction updated successfully.', 'auction' => $auction]);
    }

    /**
     * Freeze an auction (Admin functionality).
     */
    public function freeze($id)
    {
        $auction = Auction::findOrFail($id);
        $this->authorize('freeze', $auction);

        $auction->status = 'frozen';
        $auction->save();

        return response()->json(['message' => 'Auction has been frozen.']);
    }

    /**
     * Delete an auction (Admin functionality).
     */
    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $this->authorize('delete', $auction);

        $auction->delete();

        return response()->json(['message' => 'Auction deleted successfully.']);
    }

    /**
     * Track the view of an auction.
     */
    public function trackView($auctionId)
    {
        $auction = Auction::findOrFail($auctionId);
        $auction->increment('views');

        return response()->json(['message' => 'View count updated']);
    }

    public static function getUserBids(User $user)
    {
        // Fetch all auctions the user has interacted with (placed a bid on)
        $auctions = Auction::whereHas('bidsByUser', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['bidsByUser'])->get();

        $liveAuctions = [];
        $concludedAuctions = [];

        foreach ($auctions as $auction) {
            // Check if the auction needs to be concluded based on the end time
            if (AuctionStatus::isStatus($auction->status, AuctionStatus::ACTIVE) && $auction->end_time < now()) {
                $auction->conclude();
            }

            // Create an array with auction and bids details
            $auctionData = [
                'id' => $auction->id,
                'title' => $auction->title,
                'start_price' => $auction->start_price,
                'current_price' => $auction->current_price,
                'end_time' => $auction->end_time,
                'thumbnail_url' => $auction->thumbnail_url,
                'status' => $auction->status,
                'hash' => $auction->hash,
                'bids' => $auction->bidsByUser->map(function ($bid) {
                    return [
                        'id' => $bid->id,
                        'amount' => $bid->amount,
                        'created_at' => $bid->created_at,
                    ];
                }),
            ];

            // Separate auctions into live and concluded
            if (AuctionStatus::isStatus($auction->status, AuctionStatus::ENDED)) {
                $concludedAuctions[] = $auctionData;
            } else {
                $liveAuctions[] = $auctionData;
            }
        }

        return [
            'live' => $liveAuctions,
            'concluded' => $concludedAuctions,
        ];
    }
}
