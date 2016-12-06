require('./bootstrap');

Vue.component('chat', require('./components/App.vue'));
Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-message-wrap', require('./components/ChatMessageWrap.vue'));
Vue.component('new-chat-module', require('./components/NewChatModule.vue'));

export const dataBus = new Vue();

const chat = new Vue({
    el: '#chat'
});
