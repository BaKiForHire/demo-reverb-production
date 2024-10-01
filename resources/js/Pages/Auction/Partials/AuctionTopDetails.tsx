import { Auction, User } from '@/types';
import React from 'react';

interface AuctionTopDetailsProps {
    auction: Auction;
}

const AuctionTopDetails: React.FC<AuctionTopDetailsProps> = (props) => {
    const { auction } = props;

    return (
        <>
            <div className="flex flex-col md:flex-row justify-between items-start md:items-center w-full">
                <div className="flex flex-col justify-start items-start">
                    <h1 className="text-4xl font-bold"><strong>{auction.title}</strong></h1>
                    <p className="text-sm font-thin mt-2">{auction.description}</p>
                </div>

                <div className="user-details flex flex-col md:flex-row items-start md:items-center mt-4 md:mt-0 md:ml-auto p-4 md:p-6">
                    <div className="flex items-center ml-0 md:ml-4 mt-1 md:mt-0 mb-2 md:mb-0">
                        <div className="w-8 h-8 rounded-full bg-gray-300 mr-2" style={{ aspectRatio: 1 }}></div>
                        <span className="text-lg font-medium">{auction.user.name || 'Jake Paul'}</span>
                    </div>
                    <span className="ml-5 text-yellow-500 mb-2 md:mb-0">★★★★★</span>
                    <span className="ml-2 text-sm text-gray-600">4.5 out of 5 stars</span>
                </div>
            </div>
        </>
    );
}


export default AuctionTopDetails;