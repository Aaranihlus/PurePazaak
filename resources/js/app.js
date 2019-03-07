
/**
* First we will load all of this project's JavaScript dependencies which
* includes Vue and other libraries. It is a great starting point when
* building robust, powerful web applications using Vue and Laravel.
*/

require('./bootstrap');

window.Vue = require('vue');

/**
* The following block of code may be used to automatically register your
* Vue components. It will recursively scan this directory for the Vue
* components and automatically register them with their "basename".
*
* Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
*/

Vue.component('game-menu', require('./components/GameMenu.vue'));
Vue.component('create-profile', require('./components/CreateProfile.vue'));
Vue.component('profile', require('./components/Profile.vue'));
Vue.component('game', require('./components/Game.vue'));
Vue.component('deck-builder', require('./components/DeckBuilder.vue'));
Vue.component('game-list', require('./components/GameList.vue'));
Vue.component('game-listing', require('./components/GameListing.vue'));
Vue.component('versus-menu', require('./components/VersusMenu.vue'));
Vue.component('leaderboard', require('./components/Leaderboard.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

// Event Handler
Vue.prototype.$eventHub = new Vue();

const app = new Vue({
  el: '#app'

});
