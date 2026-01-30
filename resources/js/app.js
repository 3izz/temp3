import './bootstrap';
import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Alpine = Alpine;
Alpine.start();

// -----------------------------
// إعداد Laravel Echo + Pusher
// -----------------------------
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
});

// -----------------------------
// كود البيرغر (القائمة الجانبية)
// -----------------------------
document.addEventListener('DOMContentLoaded', function () {
    const burgerBtn1   = document.getElementById('burger1-btn');
    const burgerLinks1 = document.getElementById('burger1-links');

    if (burgerBtn1 && burgerLinks1) {
        burgerBtn1.addEventListener('click', function () {
            burgerLinks1.classList.toggle('active1');
        });

        // اغلاق عند الضغط خارج المنيو
        document.addEventListener('click', function (e) {
            if (!burgerLinks1.contains(e.target) && !burgerBtn1.contains(e.target)) {
                burgerLinks1.classList.remove('active1');
            }
        });
    }
});
