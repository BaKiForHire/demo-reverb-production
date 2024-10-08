import AuctionCard from '@/Components/AuctionCard';
import { Auction } from '@/types';
import { usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';

const fetchFavoritedAuctions = () => {
    return [
        { id: 8, title: 'Collector’s Revolver', currentBid: 3200, endTime: '2024-12-15 13:00' },
        { id: 9, title: 'Rare Rifle', currentBid: 2900, endTime: '2024-12-16 15:30' },
        { id: 10, title: 'Antique Sword', currentBid: 1500, endTime: '2024-12-17 17:00' },
    ];
};

type UserBids = {
    live: Auction[];
    concluded: Auction[];
}

const BuyerDashboard: React.FC = () => {
    const bids = usePage().props.bids as UserBids;
    const favorites = usePage().props.favorites as Auction[];

    return (
        <div className="p-6 bg-gray-50 min-h-screen rounded-md">
            {/* Bidding History Section */}
            <div className="mb-8">
                <h2 className="text-xl font-semibold mb-4">Bidding History</h2>
                {bids.concluded.length > 0 ? (
                    <div className="flex space-x-4 overflow-x-auto">
                        <div className="grid grid-flow-col mb-3 gap-4">
                            {bids.concluded.map((auction, index) => (
                                <AuctionCard width="w-full min-w-[240px]" key={index} auction={auction} />
                            ))}
                        </div>
                    </div>
                ) : (
                    <div className="flex justify-center items-center h-32 bg-gray-100 rounded-md">
                        <p className="text-gray-500">No bidding history available.</p>
                    </div>
                )}
            </div>

            {/* Live Auctions Section */}
            <div className="mb-8">
                <h2 className="text-xl font-semibold mb-4">Live Auctions</h2>
                {bids.live.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        {bids.live.map((auction, index) => (
                            <AuctionCard width="w-full" key={index} auction={auction} />
                        ))}
                    </div>
                ) : (
                    <div className="flex justify-center items-center h-32 bg-gray-100 rounded-md">
                        <p className="text-gray-500">No live auctions currently available.</p>
                    </div>
                )}
            </div>

            {/* Favorites Section */}
            <div className="mb-8">
                <h2 className="text-xl font-semibold mb-4">Favorites</h2>
                {favorites.length > 0 ? (
                    <div className="flex space-x-4 overflow-x-auto">
                        <div className="grid grid-flow-col mb-3 gap-4">
                            {favorites.map((auction, index) => (
                                <AuctionCard width="w-full min-w-[240px]" key={index} auction={auction} />
                            ))}
                        </div>
                    </div>
                ) : (
                    <div className="flex justify-center items-center h-32 bg-gray-100 rounded-md">
                        <p className="text-gray-500">No favorite auctions available.</p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default BuyerDashboard;
