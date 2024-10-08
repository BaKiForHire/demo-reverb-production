import { User, Tier } from '@/types';
import { usePage } from '@inertiajs/react';
import React from 'react';
import BuyerDashboard from './BuyerDashboard';
import SellerDashboard from './SellerDashboard';
import FFLDealerDashboard from './FFLDealerDashboard';

// Predefined tiers content
const tierContent = {
    buyer: {
        component: <BuyerDashboard />,
    },
    seller: {
        component: <SellerDashboard />,
    },
    ffl: {
        component: <FFLDealerDashboard />,
    },
};

const DashboardSections: React.FC = () => {
    const user = usePage().props.user as User & { tiers: Tier[] };

    return (
        <div className="max-w-6xl mx-auto my-8">
            <div className="space-y-4">
                {user.tiers.map((tier) => {
                    const tierKey = tier.name.toLowerCase(); // Convert to lowercase
                    const content = tierContent[tierKey]?.component; // Use optional chaining

                    // Render the tier content or a fallback if not found
                    return (
                        <div key={tier.id} className="p-4 border rounded-lg shadow-md bg-white mb-4">
                            <h2 className="text-xl font-bold mb-2">{tier.name} Dashboard</h2>
                            {content || <div className="text-gray-500">Dashboard for {tier.name} is not available.</div>}
                        </div>
                    );
                })}
            </div>
        </div>
    );
};

export default DashboardSections;
