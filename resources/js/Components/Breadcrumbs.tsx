import { Auction } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { BiChevronLeft, BiChevronRight } from 'react-icons/bi';

export const Breadcrumbs: React.FC = () => {
    const { auction } = usePage<{ auction: Auction }>().props;

    return (
        <nav className="flex" aria-label="Breadcrumb">
            <ol className="flex items-center space-x-4">
                <li className="flex items-center">
                    <Link href="/" className="text-gray-400 hover:text-gray-500 flex items-center bg-[#f7f7f7] rounded-full p-2">
                        <BiChevronLeft className="h-5 w-5" aria-hidden="true" />
                        <span className="sr-only">Back</span>
                    </Link>
                </li>
                <li className="flex items-center">
                    <Link href={route('home')} className="text-sm font-medium text-gray-500 hover:text-gray-700">
                        Home
                    </Link>
                    <BiChevronRight className="h-5 w-5 text-gray-400 mx-2" aria-hidden="true" />
                </li>
                <li className="flex items-center">
                    <span className="text-sm font-medium text-gray-500">
                        {auction.title}
                    </span>
                </li>
            </ol>
        </nav>
    );
};
