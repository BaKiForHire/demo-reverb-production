import { ButtonHTMLAttributes } from 'react';

export default function SecondaryButton({ className = '', disabled, children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={`inline-flex items-center px-4 py-2 bg-white border border-[#78866B] text-[#78866B] rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#78866B] transition ease-in-out duration-150 ${
                disabled && 'opacity-25'
            } ${className}`}
            disabled={disabled}
        >
            {children}
        </button>
    );
}
