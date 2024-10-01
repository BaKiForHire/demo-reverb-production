export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export type Auction = {
    id: number;
    title: string;
    current_price: string | null;
    start_price: string;
    end_time: string;
    thumbnail_url: string;
    categories: { id: number; name: string }[];
    location: any,
    favorite?: boolean;
};