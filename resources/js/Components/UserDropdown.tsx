import React from 'react';
import Dropdown from './Dropdown';
import { User } from '@/types';
import { usePage } from '@inertiajs/react';

interface UserDropdownProps {
    user: User;
}

const UserDropdown: React.FC<UserDropdownProps> = (props) => {
    const { user } = props;
    return (
        <div className="ms-3 relative">
            <Dropdown>
                <Dropdown.Trigger>
                    <span className="inline-flex rounded-md">
                        <button
                            type="button"
                            className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                        >
                            <svg
                                className="h-12 w-12 text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <circle cx="12" cy="12" r="10" />
                            </svg>
                            <div className="ms-2 text-left">
                                <span className="block text-lg font-bold">{user.name}</span> {/* Increased size of the username */}
                                <span className="block text-sm text-gray-500">
                                    {user.is_admin ? 'Administrator' : 
                                    !user?.tiers?.length ? 'Guest' : 
                                    user.tiers.map(tier => tier.name).join(', ') }</span> {/* Added user tier */}
                            </div>

                            <svg
                                className="ms-2 -me-0.5 h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fillRule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clipRule="evenodd"
                                />
                            </svg>
                        </button>
                    </span>
                </Dropdown.Trigger>

                <Dropdown.Content>
                    <Dropdown.Link href={route('dashboard')}>Dashboard</Dropdown.Link>
                    <Dropdown.Link href={route('profile.edit')}>Profile</Dropdown.Link>
                    <Dropdown.Link href={route('logout')} method="post" as="button">
                        Log Out
                    </Dropdown.Link>
                </Dropdown.Content>
            </Dropdown>
        </div>
    );
};

export default UserDropdown;