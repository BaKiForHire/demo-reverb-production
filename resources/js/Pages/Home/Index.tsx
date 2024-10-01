import React from 'react';
import Header from '../../Components/Header';
import Footer from '../../Components/Footer';
import { Auction, User } from '@/types';
import AuctionCard from '../../Components/AuctionCard';

type HomePageProps = {
    auctions: Auction[];
    user: User;
}

const Home: React.FC<HomePageProps> = (props) => {
    const {auctions } = props;

    return (
        <>
        <Header />
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 className="text-2xl font-bold">Featured Auctions</h2>
            <div style={{ minHeight: '460px' }} className="overflow-x-auto sm:overflow-visible h-full">
                <div className="flex sm:grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    {auctions.map(auction => (
                        <div key={auction.id} className="flex-shrink-0 w-auto box-border justify-self-center">
                            <AuctionCard auction={auction} />
                        </div>
                    ))}
                </div>
            </div>
            <div className="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-center">
                {auctions.map(auction => (
                    <div key={auction.id} className="flex-1 box-border justify-self-center">
                        <AuctionCard auction={auction} />
                    </div>
                ))}
            </div>
        </div>
        <Footer />
        </>
    );
};

export default Home;