<?php

use App\Events\BidPlaced;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuctionCategoryController;
use App\Http\Controllers\NotificationController;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Welcome page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::post('/place-bid', function () {
    $auction = $auction = Auction::with('media')->find(1); // Get the first auction for simplicity

    // Create a new Bid model and save it to the database
    $bid = Bid::create([
        'auction_id' => $auction->id,
        'user_id' => 1, // Dummy user ID
        'amount' => $auction->current_price ? $auction->current_price + 100 : $auction->start_price, // Incremental bid amount
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $auction->current_price = $bid->amount;

    $auction->save();

    // Emit the bid placed event with a real Bid model instance
    event(new BidPlaced($bid));
    
    return response()->json($bid);
});

// Dashboard - Requires authentication
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes - Requires authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auction routes - For managing auctions via the web interface
Route::middleware('auth')->group(function () {
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
    Route::get('/auctions/{auction}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
    Route::put('/auctions/{auction}', [AuctionController::class, 'update'])->name('auctions.update');
    Route::delete('/auctions/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
});

// Category routes - For managing auction categories via the web interface
Route::middleware('auth')->group(function () {
    Route::get('/categories', [AuctionCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AuctionCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AuctionCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [AuctionCategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [AuctionCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AuctionCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AuctionCategoryController::class, 'destroy'])->name('categories.destroy');
});

// Notification routes - For managing notifications via the web interface
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// Authentication routes
require __DIR__.'/auth.php';
