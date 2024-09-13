import { Link, Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { useState, useEffect } from 'react';
import axios from 'axios';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const [bidSocketData, setBidSocketData] = useState("woosh");
    const [responseData, setResponseData] = useState(null);

    // Handle button click to place a bid
    const handlePlaceBid = async () => {
        try {
            const response = await axios.post('/place-bid');
            console.log('[POST CALL] Response:', response.data);
            setResponseData(response.data);
        } catch (error) {
            console.error('[POST CALL] Error placing bid:', error);
        }
    };

    // Listen for the bid placed event
    useEffect(() => {
        const auctionId = 1; // Assuming we are watching auction with ID 1

        // Listen to a specific channel event (bid placed)
        window.Echo.channel(`auctions.${auctionId}`)
            .listen('.bid.placed', (event: any) => {
                setBidSocketData(event);
                console.log('[SOCKET] New Bid Event:', event);
            });
    
        return () => {
            // Clean up
            window.Echo.connector.pusher.unbind_global();
            window.Echo.leaveChannel(`auctions.${auctionId}`);
        };
    }, []);

    return (
        <>
            <Head title="Welcome" />
            <h1>Hello world!</h1>

            <pre>
                User: {JSON.stringify(auth, null, 2)}
            </pre>
            <p>LaravelVersion: {laravelVersion}</p>
            <p>PHPVersion: {phpVersion}</p>

            <button
                onClick={handlePlaceBid}
                className="bg-blue-500 text-white font-bold py-2 px-4 rounded mt-4"
            >
                Place Bid
            </button>

            <div className="mt-4">
                <h2>POST API Response Data:</h2>
                <pre>{JSON.stringify(responseData, null, 2)}</pre>
            </div>


            <div className="mt-4">
                <h2>New Bid Event(Socket) Data:</h2>
                <pre>{JSON.stringify(bidSocketData, null, 2)}</pre>
            </div>
        </>
    );
}
