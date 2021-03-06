require('./bootstrap');

Vue.component('chat', require('./components/App.vue'));
Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('chat-message-wrap', require('./components/ChatMessageWrap.vue'));
Vue.component('new-chat-module', require('./components/NewChatModule.vue'));
Vue.component('chat-message-input', require('./components/ChatMessageInput.vue'));
Vue.component('chat-online-status', require('./components/ChatOnlineStatus.vue'));
Vue.component('cookie-setter', require('./components/CookieSetter.vue'));

export const dataBus = new Vue({

    data(){
        return {
            message: '',
            messages: [],
            reloadChatTimer: null,
            chatId : null,
            currentPersonId: null,
            polling: true,
            apiBase: window.apiBase,

        }
    },
    created(){
        console.log(this.apiBase);
        this.$on('registeredChat', () => {

            this.startChat();
        });

    },

    methods: {
        getChat(){
            this.$http.get(dataBus.apiBase + '/chats/' + this.chatId)
                .then(response => {
                    this.messages = response.data.data;
                    this.$emit('chatUpdated', this.messages);
                    setTimeout(function () {
                        this.scrollBottom();
                    }.bind(this), 1); // push to the bottom of the execution stack
                }, error => {
                    //@todo error handling?
                    this.stopPollingUpdate();
                    this.polling = false;
                    console.log(error);
                });

        },

        stopPollingUpdate(){
            clearInterval(this.reloadChatTimer);
            this.$emit('pollingUpdate', false);
        },

        scrollBottom(){
            var objDiv = document.getElementById("chat-box");
            objDiv.scrollTop = objDiv.scrollHeight;
        },


        reloadChat(){

            this.getChat();


            if (!this.reloadChatTimer) {
                this.reloadChatTimer = setInterval(function () {
                    this.polling = true;
                    this.$emit('pollingUpdate', true);
                    this.getChat();
                }.bind(this), 5000);
            }
        },

        startChat(){
            if (this.validateChat()) {
                this.getChat();
                this.reloadChat();

            }

        },
        validateChat(){
            if (this.validateCookies() && this.validateChatData()) {
                return true;
            }
            return false;

        },

        validateCookies(){
            if (isNaN(dataBus.chatId)){
                return false;
            }

            //@todo validate cookie data that person is correct

            return true;
        },
        validateChatData(){
            return this.chatId && this.currentPersonId;

        }
    },

});

const chat = new Vue({
    el: '#chat'
});

const cookieSetter = new Vue({
    el: '#cookie-setter'
});

