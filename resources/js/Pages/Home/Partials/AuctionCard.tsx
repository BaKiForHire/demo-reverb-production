import { Auction } from '@/types';
import axios from 'axios';
import dayjs from 'dayjs';
import duration from 'dayjs/plugin/duration';
import React, { useEffect, useState } from 'react';
import { FaRegClock } from 'react-icons/fa';
import { HiHashtag } from 'react-icons/hi';
import { IoIosHeart, IoIosHeartEmpty } from 'react-icons/io';

dayjs.extend(duration);

type AuctionCardProps = {
    auction: Auction;
};

const apiClient = axios.create({
    baseURL: `${import.meta.env.VITE_APP_ENV === 'local' ? `${import.meta.env.VITE_APP_URL}:8000` : import.meta.env.VITE_APP_URL}`,
    withCredentials: true,
});

const AuctionCard: React.FC<AuctionCardProps> = ({ auction: initialAuction }) => {
    const [auction, setAuction] = useState<Auction>({
        ...initialAuction,
        current_price: initialAuction.current_price ?? '0', // Ensure current_price is a string
        favorite: initialAuction.favorite ?? false,
        end_time: initialAuction.end_time ?? dayjs().toISOString(),
    });

    const [isFavorite, setIsFavorite] = useState(auction.favorite);
    const [timeRemaining, setTimeRemaining] = useState('');

    const toggleFavorite = () => {
        setIsFavorite((prev) => !prev);
        setAuction((prevAuction) => ({
            ...prevAuction,
            favorite: !prevAuction.favorite,
        }));
    };

    const placeBid = async () => {
        const bidAmount = parseFloat(auction.current_price) + 100;
        try {
            const response = await apiClient.post(`/api/v1/auction/${auction.id}/place-bid`, {
                amount: bidAmount,
                auction_id: auction.id,
            });
            console.log('Success:', response.data);
            // Update the auction's current price after a successful bid
            setAuction((prevAuction) => ({
                ...prevAuction,
                current_price: response.data.bid.amount,
            }));
        } catch (error: any) {
            console.error('Error:', error.response?.data || error.message);
        }
    };

    useEffect(() => {
        const calculateTimeRemaining = () => {
            const now = dayjs();
            const end = dayjs(auction.end_time);
            const diff = end.diff(now);

            if (diff <= 0) {
                setTimeRemaining('00:00');
                return;
            }

            const duration = dayjs.duration(diff);
            if (duration.asDays() >= 1) {
                setTimeRemaining(`${Math.floor(duration.asDays())}d ${duration.hours().toString().padStart(2, '0')}h`);
            } else if (duration.asHours() >= 1) {
                setTimeRemaining(`${duration.hours().toString().padStart(2, '0')}h ${duration.minutes().toString().padStart(2, '0')}m`);
            } else {
                setTimeRemaining(`${duration.minutes().toString().padStart(2, '0')}m ${duration.seconds().toString().padStart(2, '0')}s`);
            }
        };

        // Listen for auction events
        const auctionChannel = window.Echo.channel(`auctions.${auction.id}`);
        auctionChannel.listen('.bid.placed', (event: any) => {
            console.log('[SOCKET] New Bid Event:', event);
            setAuction((prevAuction) => ({
                ...prevAuction,
                current_price: event.bid?.amount ?? prevAuction.current_price,
            }));
        });

        calculateTimeRemaining();
        const interval = setInterval(calculateTimeRemaining, 1000);

        return () => {
            clearInterval(interval);
            auctionChannel.stopListening('.bid.placed');
        };
    }, [auction.end_time, auction.id]);

    return (
        <div className="overflow-hidden rounded-3xl border-none border-gray-300 max-w-xs min-w-[calc(25%-1rem)] shadow-md bg-[#f4f4f4] m-2 h-full flex flex-col relative">
            <img src={auction.thumbnail_url} alt={auction.title} className="w-full rounded-t-3xl flex-shrink-0" />

            <button onClick={toggleFavorite} className="absolute top-3 right-3 text-2xl text-white font-bold hover:text-red-500 focus:outline-none">
                {isFavorite ? <IoIosHeart /> : <IoIosHeartEmpty />}
            </button>

            <div className="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h2 className="text-xl font-semibold">{auction.title.length > 25 ? auction.title.substring(0, 25) + '...' : auction.title}</h2>
                    <p className="mt-2">Current Bid: ${auction.current_price}
                        <button onClick={placeBid} className="w-min bg-[#78866b] mx-2 text-white text-xs whitespace-nowrap p-1 rounded-md hover:bg-green-950 focus:outline-none">
                            Bid +100
                        </button>
                    </p>
                </div>
                <p>Buy It Now: ${auction.start_price}</p>
            </div>

            <div className="p-4 flex justify-between items-center">
                <div className="flex items-center text-gray-600">
                    <FaRegClock className="mr-1" />
                    <span>{timeRemaining}</span>
                </div>
                <div className="flex items-center text-gray-600">
                    <HiHashtag className="mr-1" />
                    <span>ID: {auction.id}</span>
                </div>
            </div>
        </div>
    );
};

export default AuctionCard;
