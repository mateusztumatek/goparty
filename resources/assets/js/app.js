
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'jquery-ui';

import 'jquery-ui/ui/effect.js';
import 'jquery-ui/ui/effects/effect-fade.js';
import 'jquery-ui/ui/effects/effect-blind.js';
import 'jquery-ui/ui/widgets/slider.js';
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-ui/ui/widgets/resizable.js';

window.jquery_ui = require('jquery-ui');
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('address-search-box', require('./components/addressSearchBoxWithMap'));
Vue.component('city-search-box', require('./components/citySearchFieldAutoComplete'));
Vue.component('nearest-clubs', require('./components/nearestClubs'));
Vue.component('nearest-events', require('./components/nearestEvents'));
Vue.component('take-part', require('./components/takePartComponent'));
// Vue.component('slider', require('./components/slider'));

axios.defaults.baseURL = 'http://localhost/goparty/public/';

const app = new Vue({
    el: '#app'
});
