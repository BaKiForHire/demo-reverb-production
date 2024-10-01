import { BBBBuyItNow, BBBCurrentBid, BBBTimeLeft } from '@/Icons/BBBIcons';
import React from 'react';

interface AuctionDetailsSectionProps {
    currentBid: string;
    buyItNowPrice: string;
    timeLeft: string;
    onPlaceBid: () => void;
    onBuyItNow: () => void;
}

const AuctionDetailsSection: React.FC<AuctionDetailsSectionProps> = ({ currentBid, buyItNowPrice, timeLeft, onPlaceBid, onBuyItNow }) => {
    return (
        <div className="bg-gray-100 rounded-lg p-4 my-4">
            <div className="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-4">
                {/* Prices Row */}
                <div className="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-2 sm:gap-4 mb-4 sm:mb-0 w-full">
                    <div className="flex items-center gap-1 w-full sm:w-auto">
                        <BBBCurrentBid className="mr-1" />
                        <span className="text-[#848484] text-lg">Current Bid:</span>
                        <span className="text-[#78866b] text-lg ml-1">${currentBid}</span>
                    </div>
                    <div className="flex items-center gap-1 w-full sm:w-auto">
                        <BBBBuyItNow className="mr-1" />
                        <span className="text-[#848484] text-lg">Buy It Now:</span>
                        <span className="text-[#78866b] text-lg ml-1">${buyItNowPrice}</span>
                    </div>
                    <div className="flex items-center gap-1 w-full sm:w-auto">
                        <BBBTimeLeft className="mr-1" />
                        <span className="text-[#848484] text-lg">Time Left:</span>
                        <span className="text-black text-lg font-bold ml-1">{timeLeft}</span>
                    </div>
                </div>

                {/* Action Buttons Row */}
                <div className="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <button
                        onClick={onPlaceBid}
                        className="p-2 bg-[#78866b] text-white rounded-md font-semibold uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 normal-case whitespace-nowrap justify-center"
                    >
                        Place Bid
                    </button>
                    <button
                        onClick={onBuyItNow}
                        className="p-2 border border-[#78866b] text-[#78866b] bg-white rounded-md font-semibold uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 normal-case whitespace-nowrap justify-center"
                    >
                        Buy It Now
                    </button>
                </div>
            </div>
        </div>
    );
};

export default AuctionDetailsSection;
