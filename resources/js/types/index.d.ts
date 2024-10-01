export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    [key: string]: any;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export interface Coordinates {
    latitude: number;
    longitude: number;
}

export interface Location {
    id: number;
    street_address: string;
    coordinates: Coordinates;
    postal_code: string;
    state: string;
    city: string;
    created_at: string;
    updated_at: string;
}

export interface Media {
    id: number;
    auction_id: number;
    media_type: string;
    url: string;
    alt_text: string;
    created_at: string;
    updated_at: string;
}

export interface CategoryPivot {
    auction_id: number;
    auction_category_id: number;
}

export interface Category {
    id: number;
    name: string;
    description: string;
    created_at: string;
    updated_at: string;
    pivot: CategoryPivot;
}

export interface Bid {
    auction_id: number;
    user_id: number;
    amount: string;
    created_at: string;
    updated_at: string;
}

export interface Auction {
    id: number;
    title: string;
    description: string;
    start_price: string;
    current_price: string;
    start_time: string;
    end_time: string;
    user_id: number;
    status: string;
    thumbnail_url: string;
    created_at: string;
    updated_at: string;
    views: number;
    location_id: number;
    has_shipping_proof: boolean;
    shipping_proof_url: string | null;
    grace_extension_count: number;
    hash: string;
    location: Location;
    user: User;
    media: Media[];
    categories: Category[];
    bids: Bid[];
    favorite?: boolean;
}
