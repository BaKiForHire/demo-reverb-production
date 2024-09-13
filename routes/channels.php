<?php

use App\Models\Auction;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('auctions.{auctionId}', function ($user, $auctionId) {
    return $user->canBidOnAuction($auctionId); // Authorization logic
});

Broadcast::channel('auction.bid.{auctionId}', function ($user, $auctionId) {
    return $user->canBidOnAuction($auctionId); // Authorization logic for bidding
});

Broadcast::channel('auction.view.{auctionId}', function ($user, $auctionId) {
    return $user->can('view', Auction::find($auctionId)); // Authorization logic for viewing
});

Broadcast::channel('admin.auctions.{auctionId}', function ($user, $auctionId) {
    return $user->is_admin;
});
