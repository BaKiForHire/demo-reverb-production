import { BBBClose, BBBNotification } from '@/Icons/BBBIcons';
import { useEffect, useState } from 'react';

type ToastProps = {
    title: string;
    message: string;
    onClose?: () => void;
    type: ToastType;
};

const palette = {
    success: {
        color: '#78866b',
        icon: <BBBNotification type="success" />,
    },
    error: {
        color: '#ff507a',
        icon: <BBBNotification type="error" />,
    },
    warning: {
        color: '#ff9900',
        icon: <BBBNotification type="warning" />,
    },
    info: {
        color: '#ff9900',
        icon: <BBBNotification type="info" />,
    },
}

export enum ToastType {
    SUCCESS = 'success',
    ERROR = 'error',
    WARNING = 'warning',
    INFO = 'info',
}

export default function Toast({ title, message, type, onClose }: ToastProps) {
    const [visible, setVisible] = useState(true);

    useEffect(() => {
        const timer = setTimeout(() => {
            setVisible(false);
            if (onClose) onClose();
        }, parseInt(import.meta.env.REACT_APP_TOAST_DURATION || '5000')); // Hide after specified duration or default to 5 seconds

        return () => clearTimeout(timer);
    }, []);

    if (!visible) return null;

    return (
        <div className="fixed top-5 right-5 max-w-sm w-full bg-white shadow-md rounded-lg border border-gray-200 flex overflow-hidden">
            {/* Left Column: Icon */}
            <div 
                className="flex items-center justify-center w-16" 
                style={{ backgroundColor: `${palette[type].color}40` }} // Adding 40 for 25% opacity in hex
            >
                {palette[type].icon}
            </div>

            {/* Center Column: Textual Content */}
            <div className="flex-1 p-4" style={{ color: palette[type].color }}>
                <h4 className="font-bold text-black">{title}</h4>
                <p>{message}</p>
            </div>

            {/* Right Column: Close Button */}
            <button
                className="absolute top-2 right-2 text-gray-400 hover:text-gray-600"
                onClick={() => {
                    setVisible(false);
                    if (onClose) onClose();
                }}
            >
                <BBBClose />
            </button>
        </div>
    );
}
