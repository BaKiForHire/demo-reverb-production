import React, { useState } from 'react';
import { Box } from '@chakra-ui/react';
import { FaChevronDown, FaBomb, FaCog, FaAsterisk } from 'react-icons/fa';
import { GiPistolGun, GiWinchesterRifle } from "react-icons/gi";
import PrimaryButton from '@/Components/PrimaryButton';
import BBBHandgun from '../Icons/BBBHandgun';
import BBBRifle from '../Icons/BBBRifle';
import BBBShotgun from '../Icons/BBBShotgun';
import BBBAmmo from '../Icons/BBBAmmo';
import BBBParts from '../Icons/BBBParts';
import { Link, useForm, usePage } from '@inertiajs/react';
import ApplicationLogo from './ApplicationLogo';
import Dropdown from './Dropdown';
import UserDropdown from './UserDropdown';

const Header: React.FC = () => {
    const [isOpen, setIsOpen] = useState(false);
    const user: any = usePage().props.user;

    // Toggle the mobile menu
    const toggleMenu = () => {
        setIsOpen(!isOpen);
    };

    // Menu items data for reusability
    const menuItems = [
        { name: 'Handguns', icon: <BBBHandgun /> },
        { name: 'Rifles', icon: <BBBRifle /> },
        { name: 'Shotguns', icon: <BBBShotgun /> },
        { name: 'Ammo', icon: <BBBAmmo /> },
        { name: 'Parts', icon: <BBBParts /> },
    ];

    return (
        <header className="bg-[#fefefe] text-black">
            {/* Top Box Element - Don't Change */}
            <Box bg="#78866B" py={8} textAlign="center" color="white" fontWeight="bold" className="uppercase">
                FREE SHIPPING ON ORDERS OVER $200!
            </Box>

            {/* Header Content */}
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between custom-md:justify-center items-center py-4">
                    {/* Logo */}
                    <div className="text-2xl">
                        <ApplicationLogo />
                    </div>

                    {/* Desktop Navigation */}
                    <div className="hidden custom-md:block max-w-7xl">
                        <div className="flex">
                            <nav className="flex justify-around items-center">
                                {menuItems.map((item) => (
                                    <a
                                        key={item.name}
                                        href="#"
                                        className="flex items-center p-3 space-x-2 hover:bg-gray-200 rounded uppercase font-bold"
                                    >
                                        <span className="text-xl hidden lg:inline">{item.icon}</span> {/* Icon shown only on screens larger than 1060px */}
                                        <span>{item.name}</span>
                                        <FaChevronDown className="ml-2" />
                                    </a>
                                ))}
                            </nav>

                            {/* Action Button */}
                            <div className="text-right flex gap-3 flex-col items-end self-center">
                                {user ? (
                                    <UserDropdown user={user} />
                                ) : (
                                    <Link
                                        className="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-950 focus:bg-green-950 active:bg-green-950 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 bg-[#78866b] normal-case whitespace-nowrap justify-center w-full"
                                        href={route('login')}
                                    >
                                        Sign In
                                    </Link>
                                )}
                            </div>
                        </div>

                        {/* Search Bar */}
                        <div className="relative">
                            <input
                                type="text"
                                placeholder="Search for products..."
                                className="w-full p-3 border border-[#d8d8d8] rounded bg-[#f5f5f5] pr-10 max-h-11"
                            />
                            <svg
                                className="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"
                                />
                            </svg>
                        </div>
                    </div>

                    {/* Mobile Menu Button */}
                    <div className="custom-md:hidden">
                        <button onClick={toggleMenu} className="focus:outline-none">
                            <svg
                                className="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d={isOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'}
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {/* Mobile Sidebar */}
            <div
                className={`fixed z-10 top-0 left-0 h-full w-64 bg-[#fefefe] text-black transform ${isOpen ? 'translate-x-0' : '-translate-x-full'
                    } transition-transform duration-300 ease-in-out custom-md:hidden`} > {/* Only shown on screens smaller than 890px */}
                <div className="flex justify-end p-4">
                    <button onClick={toggleMenu} className="focus:outline-none">
                        <svg
                            className="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                {/* User Info */}
                <div className="px-4 pt-4">
                    {user ? (
                        <UserDropdown user={user} />
                    ) : (
                        <Link
                            className="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-green-950 focus:bg-green-950 active:bg-green-950 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 bg-[#78866b] normal-case whitespace-nowrap justify-center w-full"
                            href={route('login')}
                        >
                            Sign In
                        </Link>
                    )}
                </div>

                {/* Mobile Search Bar */}
                <div className="px-4 pt-4">
                    <div className="relative">
                        <input
                            type="text"
                            placeholder="Search for products..."
                            className="w-full p-3 border border-[#d8d8d8] rounded bg-[#f5f5f5] pr-10 max-h-11"
                        />
                        <svg
                            className="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"
                            />
                        </svg>
                    </div>
                </div>

                <nav className="px-4 pt-4 space-y-2">
                    {menuItems.map((item) => (
                        <a
                            key={item.name}
                            href="#"
                            className="flex items-center p-3 space-x-2 hover:bg-gray-200 rounded"
                        >
                            <span className="text-xl">{item.icon}</span>
                            <span className="flex-1">{item.name}</span>
                            <FaChevronDown className="ml-auto" />
                        </a>
                    ))}
                </nav>
            </div>
        </header>
    );
};

export default Header;
