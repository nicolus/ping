import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Toaster from "./toasts";
import Alpine from 'alpinejs'

window.Alpine = Alpine;
Alpine.start()


window.Echo = new Echo({
    broadcaster: 'pusher',
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
    enabledTransports: ["ws", "wss"],
});


window.Echo.private(`App.Models.User.1`).notification((e) => {
   if(e.title && e.text) {
       Toaster.makeToast(e.title, e.text, e.style);
   }
});