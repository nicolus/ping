import './bootstrap';
import Toaster from "./toasts";
import Alpine from 'alpinejs'

window.Alpine = Alpine;
Alpine.start()

window.Echo.private(`App.Models.User.1`).notification((e) => {
   if(e.title && e.text) {
       Toaster.makeToast(e.title, e.text, e.style);
   }
});