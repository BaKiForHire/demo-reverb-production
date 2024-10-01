import React from 'react';

const AuctionDisclaimer: React.FC = () => {
    return (
        <div className="bg-gray-100 rounded-lg p-4">
            <h2 className="text-xl font-bold tracking-tight text-[#78866b]">Disclaimer: Big Bore Bids</h2>
            <p className="text-[#78866b]">
            All bids are final, and users participate at their own risk. Big Bore Bids is not responsible for item accuracy, 
            condition, or disputes between buyers and sellers. Participation implies acceptance of these terms.
            </p>
        </div>
    );
};

export default AuctionDisclaimer;