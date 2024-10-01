import React, { useState } from 'react';

interface Media {
    id: number;
    url: string;
}

interface AuctionMediaComponentProps {
    media: Media[];
}

const AuctionMediaComponent: React.FC<AuctionMediaComponentProps> = ({ media }) => {
    const [selectedMedia, setSelectedMedia] = useState<Media>(media[0]);

    const handleThumbnailClick = (mediaItem: Media) => {
        setSelectedMedia(mediaItem);
    };

    return (
        <div className="flex flex-col-reverse md:flex-row">
            <div className="custom-scroll md:w-1/4 items-center flex md:flex-col overflow-x-auto md:overflow-y-auto md:overflow-x-hidden scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-transparent max-h-96">
            {media.map((mediaItem) => (
                <img
                key={mediaItem.id}
                src={mediaItem.url}
                alt={`Media ${mediaItem.id}`}
                className="w-24 h-auto cursor-pointer mb-2 md:mb-0 md:mr-0 mr-2 p-2"
                style={{ clipPath: 'none' }}
                onClick={() => handleThumbnailClick(mediaItem)}
                />
            ))}
            </div>
            <div className="md:w-3/4 mt-4 md:mt-0 md:ml-4 flex justify-center items-center">
            <img src={selectedMedia.url} alt="Selected Media" className="max-w-full max-h-96 object-contain" />
            </div>
        </div>
    );
};

export default AuctionMediaComponent;