import { Auction, User } from '@/types';
import React, { useEffect, useState } from 'react';
import Header from '../../Components/Header';
import Footer from '../../Components/Footer';
import { Breadcrumbs } from '@/Components/Breadcrumbs';
import AuctionTopDetails from './Partials/AuctionTopDetails';
import AuctionDetailsSection from './Partials/AuctionDetailsSection';
import dayjs from 'dayjs';
import duration from 'dayjs/plugin/duration';
import AuctionMediaComponent from './Partials/AuctionMediaComponent';
import AuctionDescription from './Partials/AuctionDescription';
import AuctionDisclaimer from './Partials/AuctionDisclamer';
import AuctionDetailsCard from './Partials/AuctionDetailsCard';

dayjs.extend(duration);

type AuctionIndexProps = {
    auction: Auction;
    user: User;
};

const AuctionIndex: React.FC<AuctionIndexProps> = (props) => {
    const { auction, user } = props;
    const [timeRemaining, setTimeRemaining] = useState('');

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

        calculateTimeRemaining();
        const interval = setInterval(calculateTimeRemaining, 1000);

        return () => {
            clearInterval(interval);
        };
    }, [auction.end_time, auction.id]);

    return (
        <>
            <Header />
            <div className="auction-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <Breadcrumbs />
                <AuctionTopDetails auction={auction} />
                <AuctionDetailsSection
                    currentBid={auction.current_price}
                    buyItNowPrice={auction.start_price}
                    timeLeft={timeRemaining}
                    onBuyItNow={() => console.log('Buy It Now')}
                    onPlaceBid={() => console.log('Place Bid')}
                />

                <AuctionMediaComponent media={[{id: 0, url: auction.thumbnail_url}, ...auction.media]} />
                
                <div className="flex flex-col lg:flex-row lg:space-x-8 mt-8">
                    <div className="lg:w-3/4 space-y-8">
                        <AuctionDescription description={auction.description} />
                        <AuctionDisclaimer />
                    </div>
                    <div className="lg:w-1/4 mt-8 lg:mt-0">
                        <AuctionDetailsCard />
                    </div>
                </div>
            </div>
            <Footer />
        </>
    );
};

export default AuctionIndex;
