import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Toaster from "./toasts";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


window.Echo.private(`App.Models.User.1`).notification((e) => {
    console.log(e);
    Toaster.makeToast(e.title, e.text, e.style);
});