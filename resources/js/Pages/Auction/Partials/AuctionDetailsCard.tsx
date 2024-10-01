import { BBBBuyItNow, BBBClock, BBBCurrentBid, BBBEye, BBBHashTag, BBBStatus } from '@/Icons/BBBIcons';
import { Auction } from '@/types';
import { usePage } from '@inertiajs/react';
import React from 'react';
import { FaClock, FaDollarSign, FaGavel, FaEye, FaInfoCircle } from 'react-icons/fa';
import { HiHashtag } from 'react-icons/hi';

const AuctionDetailsCard: React.FC = () => {
    const auction = usePage().props.auction as Auction;

    return (
        <div className="bg-gray-100 p-4 rounded-lg shadow-md">
            <div className="mb-4">
                <h5 className="text-xl font-semibold flex items-center mb-2">
                    { auction.title.length > 20 ? auction.title.substring(0, 20) + '...' : auction.title }
                </h5>
                <div className="grid grid-cols-1 gap-4">
                    <div className="flex items-center col-span-1 w-full">
                        <BBBCurrentBid className="mr-2" />
                        <span>Current Bid: <span >$100</span></span>
                    </div>
                    <div className="flex items-center col-span-1 w-full">
                        <BBBBuyItNow className="mr-2" />
                        <span>Buy It Now Price: $500</span>
                    </div>
                    <div className="flex items-center col-span-1 w-full">
                        <BBBHashTag className="mr-2" />
                        <span>Bids: <span className="text-black">10</span></span>
                    </div>
                    <div className="flex items-center col-span-1 w-full">
                        <BBBClock className="mr-2" />
                        <span>Time Left: <span className="text-black">2d 4h</span></span>
                    </div>
                    <div className="flex items-center col-span-1 w-full">
                        <BBBEye className="mr-2" />
                        <span>Views: <span className="text-black">150</span></span>
                    </div>
                    <div className="flex items-center col-span-1 w-full">
                        <BBBStatus className="mr-2" />
                        <span>Status: <span className="text-black"><b>Active</b></span></span>
                    </div>
                </div>
            </div>
            <div className="flex flex-col gap-4 mt-4">
                <button className="p-2 border border-[#78866b] text-[#78866b] bg-white rounded-md font-semibold uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 normal-case whitespace-nowrap justify-center">
                    Buy Now
                </button>
                <button className="p-2 bg-[#78866b] text-white rounded-md font-semibold uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 normal-case whitespace-nowrap justify-center">
                    Place Bid
                </button>
                <button className="p-2 border border-[#78866b] text-[#78866b] bg-white rounded-md font-semibold uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 normal-case whitespace-nowrap justify-center">
                    Make an Offer
                </button>
            </div>
        </div>
    );
};

export default AuctionDetailsCard;
