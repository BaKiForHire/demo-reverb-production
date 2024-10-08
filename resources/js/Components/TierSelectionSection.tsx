// Components/TierSelectionSection.tsx
import { Tier } from '@/types';

type TierSelectionProps = {
    availableTiers: Tier[];
    onTierSelect: (tier: Tier) => void;
};

export default function TierSelectionSection({ availableTiers, onTierSelect }: TierSelectionProps) {
    return (
        <div className="text-gray-900">
            <p>You currently have no tiers. Complete your profile to start bidding or selling!</p>
            <div className="mt-4 space-x-4">
                {availableTiers.map((tier: Tier) => (
                    <button
                        key={tier.id}
                        className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700"
                        onClick={() => onTierSelect(tier)}
                    >
                        Become a {tier.name}
                    </button>
                ))}
            </div>
        </div>
    );
}
