window.Vue = require('vue');

window._ = require('lodash');

require('es6-promise').polyfill();

window.axios = require('axios');

window.velocity = require('velocity-animate');

window.moment = require('moment');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.select2 = require('select2');


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
