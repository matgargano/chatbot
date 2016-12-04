require('./bootstrap');

Vue.component('chat', require('./components/App.vue'));

const chat = new Vue({
    el: '#chat'
});
