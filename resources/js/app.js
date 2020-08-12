/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. **/

require('jquery');
require('popper.js');
require('./bootstrap');
require('pace');
require('perfect-scrollbar');
require('@coreui/coreui');

window.Vue = require('vue');

import Vuex from 'vuex'
import VuePaginate from 'vue-paginate'
import Multiselect from 'vue-multiselect'
import VuejsDialog from 'vuejs-dialog';
import VueNotification from '@mathieustan/vue-notification';

Vue.component('multiselect', Multiselect)

Vue.use(Vuex)
Vue.use(VuePaginate);
Vue.use(VueNotification);
Vue.use(VuejsDialog);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dashboardComponent', require('./components/DashboardComponent.vue').default);
Vue.component('moviesComponent', require('./components/MoviesComponent.vue').default);
Vue.component('serversComponent', require('./components/ServersComponent.vue').default);
Vue.component('genresComponent', require('./components/GenresComponent.vue').default);
Vue.component('seriesComponent', require('./components/SeriesComponent.vue').default);
Vue.component('livetvComponent', require('./components/LivetvComponent.vue').default);
Vue.component('notificationsComponent', require('./components/NotificationsComponent.vue').default);
Vue.component('settingsComponent', require('./components/SettingsComponent.vue').default);
Vue.component('accountComponent', require('./components/AccountComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el : '#app',
});

