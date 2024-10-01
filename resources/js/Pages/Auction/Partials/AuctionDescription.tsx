import React from 'react';

interface AuctionDescriptionProps {
    description: string;
}

const AuctionDescription: React.FC<AuctionDescriptionProps> = ({ description }) => {
    return (
        <div>
            <h1 className="text-2xl font-bold">Product Description:</h1>
            <p className="text-justify">{description}</p>
        </div>
    );
};

export default AuctionDescription;