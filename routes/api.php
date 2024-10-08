<?php

use App\Http\Controllers\API\V1\BidAPIController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\UserTierKeyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuctionCategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteAuctionController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\TierEvaluationController;
use App\Http\Controllers\UserTierKeyValueController;

// API v1 Routes - Prefixed with 'api/v1/'
Route::prefix('v1')->group(function () {

    // Testing route
    Route::post('/test-no-auth', [BidAPIController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/test-auth', [BidAPIController::class, 'store']);
    });

    // User routes - Authentication and user management
    Route::middleware('auth:api')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::post('/users/{id}/upgrade-tier', [UserController::class, 'upgradeTier']);
        Route::delete('/users/{id}', [UserController::class, 'delete']);
        Route::post('/users/use-my-location', [UserController::class, 'shareLocation']);
    });

    // Auction routes - Managing auctions
    Route::middleware('auth:api')->group(function () {
        Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
        Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
        Route::get('/auctions/{id}', [AuctionController::class, 'show'])->name('auctions.show');
        Route::put('/auctions/{id}', [AuctionController::class, 'update'])->name('auctions.update');
        Route::post('/auctions/{id}/freeze', [AuctionController::class, 'freeze'])->name('auctions.freeze');
        Route::delete('/auctions/{id}', [AuctionController::class, 'delete'])->name('auctions.delete');
        Route::post('/auctions/{auctionId}/media', [AuctionController::class, 'storeMedia'])->name('auctions.storeMedia');
    });

    // Bid routes - Placing and managing bids
    Route::middleware('auth:api')->group(function () {
        Route::post('/bids', [BidController::class, 'store']);
        Route::get('/auctions/{auctionId}/bids', [BidController::class, 'index']);
        Route::post('/auction/{id}/place-bid', [BidController::class, 'store']);
    });

    // FavoriteAuction routes - Managing favorite auctions
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/favorite/set/{auctionHash}', [FavoriteAuctionController::class, 'set'])->name('favorite.set');
        Route::post('/favorite/unset/{auctionHash}', [FavoriteAuctionController::class, 'unset'])->name('favorite.unset');
    });

    // Tier routes - Managing user tiers
    Route::middleware('auth:api')->group(function () {
        Route::get('/tiers', [TierController::class, 'index']);
        Route::get('/tiers/{id}', [TierController::class, 'show']);
        Route::post('/tiers', [TierController::class, 'store']);
        Route::put('/tiers/{id}', [TierController::class, 'update']);
    });

    // UserTierKey routes - Managing dynamic keys for user tiers
    Route::middleware('auth:api')->group(function () {
        Route::get('/tiers/{tierId}/keys', [UserTierKeyController::class, 'index'])->name('tiers.keys');
        Route::post('/tiers/keys', [UserTierKeyController::class, 'store']);
        Route::put('/tiers/keys/{id}', [UserTierKeyController::class, 'update']);
        Route::post('/tiers/keys/{id}/disable', [UserTierKeyController::class, 'disable']);

        // UserTierKeyValue routes - Managing user tier key values
        Route::post('/tiers/tier-key-values', [UserTierKeyValueController::class, 'storeOrUpdate'])->name('tiers.key-values');

        Route::post('/tiers/tier-evaluation', [TierEvaluationController::class, 'evaluate'])->name('tiers.evaluate');
    });

    // Notification routes - Managing notifications
    Route::middleware('auth:api')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    });

    // AuctionCategory routes - Managing auction categories
    Route::middleware('auth:api')->group(function () {
        Route::get('/categories', [AuctionCategoryController::class, 'index']);
        Route::get('/categories/{id}', [AuctionCategoryController::class, 'show']);
        Route::post('/categories', [AuctionCategoryController::class, 'store']);
        Route::put('/categories/{id}', [AuctionCategoryController::class, 'update']);
        Route::delete('/categories/{id}', [AuctionCategoryController::class, 'delete']);
    });

    // Auction - Viewing auctions
    Route::post('/auctions/{auction}/view', [AuctionController::class, 'trackView']);

    // Comment routes - Managing comments on auctions
    Route::post('/auctions/{auction}/comments', [CommentController::class, 'store']);
    Route::post('/comments/{comment}/upvote', [CommentController::class, 'upvote']);

    // NewsletterSubscription routes - Managing newsletter subscriptions
    Route::post('/newsletter/subscribe', [NewsletterSubscriptionController::class, 'subscribe']);
    Route::post('/newsletter/unsubscribe', [NewsletterSubscriptionController::class, 'unsubscribe']);
});
