require('./bootstrap');

Vue.component('chat', require('./components/App.vue'));
Vue.component('chat-message', require('./components/ChatMessage.vue'));

const chat = new Vue({
    el: '#chat'
});
