import { Box, Grid, GridItem, Heading, Text, Button, Image, VStack, HStack, Tag } from '@chakra-ui/react';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';
import { useEffect, useState } from 'react';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import axios from 'axios';

dayjs.extend(relativeTime);

type Auction = {
    id: number;
    title: string;
    current_price: string | null;
    start_price: string;
    end_time: string;
    thumbnail_url: string;
    categories: { id: number; name: string }[];
};

const apiClient = axios.create({
    baseURL: `${import.meta.env.VITE_APP_ENV === 'local' ? `${import.meta.env.VITE_APP_URL}:8000` : import.meta.env.VITE_APP_URL}`, // Adjust the base URL as necessary
    withCredentials: true,            // This ensures that cookies are sent with the request
});

export default function Welcome({ latestAuctions }: PageProps<{ latestAuctions: Auction[] }>) {
    const [timeLeft, setTimeLeft] = useState<{ [key: number]: string }>({});
    const [auctions, setAuctions] = useState<Auction[]>(latestAuctions);

    // Update the time left for each auction every second
    useEffect(() => {
        const timer = setInterval(() => {
            setTimeLeft((prevState) => {
                const newTimeLeft = auctions.reduce((acc, auction) => {
                    const remainingTime = dayjs(auction.end_time).fromNow(true);
                    return { ...acc, [auction.id]: remainingTime };
                }, {});
                return { ...prevState, ...newTimeLeft };
            });
        }, 1000);

        return () => clearInterval(timer);
    }, [auctions]);

    // Subscribe to Pusher for real-time auction updates (on component mount)
    useEffect(() => {
        auctions.forEach((auction) => {
            window.Echo.channel(`auctions.${auction.id}`)
                .listen('.bid.placed', (event: any) => {
                    console.log('[SOCKET] New Bid Event:', event);
                    // Use functional update to ensure correct state management
                    setAuctions((prevAuctions) =>
                        prevAuctions.map((a) =>
                            a.id === event.auction_id ? { ...a, current_price: event.amount } : a
                        )
                    );
                });
        });

        return () => {
            // Clean up subscriptions when component unmounts
            window.Echo.connector.pusher.unbind_global();
        };
    }, []);

    const handleBid = async (auctionID: number, amount: number = 100) => {
        console.log(`Placing a bid of 100 on auction ${auctionID}`);

        // Use up-to-date state for auction prices
        const auction = auctions.find((a) => a.id === auctionID);
        if (!auction) return console.log('Auction not found');

        let bidAmount = parseFloat(auction.current_price || auction.start_price) + amount;

        try {
            const response = await apiClient.post(`/api/v1/auction/${auctionID}/place-bid`, {
                amount: bidAmount,
                auction_id: auctionID,
            });
            console.log('Success:', response.data);
        } catch (error: any) {
            console.error('Error:', error.response?.data || error.message);
        }
    };

    return (
        <>
            <Head title="Welcome" />
            <Box p={6}>
                <Heading as="h1" mb={6} textAlign="center">
                    Active Auctions
                </Heading>
                <Grid templateColumns="repeat(4, 1fr)" gap={6}>
                    {auctions.slice(0, 12).map((auction) => (
                        <GridItem key={auction.id} w="100%">
                            <Box borderWidth="1px" borderRadius="lg" overflow="hidden" p={4}>
                                <Image src={auction.thumbnail_url} alt={auction.title} borderRadius="md" />
                                <VStack align="start" mt={4}>
                                    <Heading size="md">{auction.title}</Heading>
                                    <Heading size="md">ID: {auction.id}</Heading>
                                    <HStack>
                                        {auction.categories.map((category) => (
                                            <Tag key={category.id} colorScheme="blue">
                                                {category.name}
                                            </Tag>
                                        ))}
                                    </HStack>
                                    <Text>
                                        Price: ${auction.current_price ? auction.current_price : auction.start_price}
                                    </Text>
                                    <Text>Ends in: {timeLeft[auction.id]}</Text>
                                    <Button
                                        style={{ border: '1px solid black', width: '100%' }}
                                        colorScheme="blue"
                                        mt={4}
                                        onClick={() => handleBid(auction.id)}
                                    >
                                        Bid +100
                                    </Button>
                                </VStack>
                            </Box>
                        </GridItem>
                    ))}
                </Grid>
            </Box>
        </>
    );
}
