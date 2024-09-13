import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST, // Should resolve to localhost or the server's IP
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 6002, // Fallback to 6002 if undefined
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443, // For secure WebSocket, but not required since using http/ws
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https', // Ensure `http` is used
    enabledTransports: ['ws'], // We only need ws for non-secure WebSocket
});