<style scoped>


.chat-window {
    width:300px;
}

.chat-input {
    padding:5px;
    width:100%;
}

.chat-box {
    max-height:250px;
    overflow-y:auto;
}

.error {
    color:#FF0000;
}







</style>
<template>
    <div>

        <div v-if="!chatId">
            <div class="error" v-if="errorMsg">
                {{ errorMsg }}
            </div>
            <label for="name">Email <input @keyup.enter="initChat" id="email" type="email" v-model="email"></label>
            <label for="name">Name <input @keyup.enter="initChat" id="name" type="text" v-model="name"></label>
            <button class="btn btn-primary" @click="initChat">+</button>
        </div>
        <div v-else>


            <div class="chat-window">
                <div class="panel panel-primary">
                    <div class="panel-heading"> Support
                        <small v-if="online">online</small>
                        <small v-else>offline</small>
                    </div>

                    <div class="chat-box" id="chat-box">
                        <chat-message-wrap :messages="messages" :currentPersonId="currentPersonId"></chat-message-wrap>
                    </div>
                    <input class="chat-input" type="text" v-model="currentChatMessage" @keyup.enter="submitChat">
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    export default {

        data(){
           return {
                chatId: '',
                messages: [],
                currentPersonId: '',
                email: '',
                name: '',
                online: true, // this can be modified
                messagePerson: false,
                currentChatMessage: '',
                reloadChatTimer: null,
                errorMsg: ''

            }

        },
        created(){
            this.chatId = this.$cookie.get('chat');
            this.currentPersonId = this.$cookie.get('person');
            this.validateChat();
            if(this.chatId && this.currentPersonId){
                this.getChat();
                this.reloadChat();

            }
        },
        methods: {
            scrollBottom(){
                var objDiv = document.getElementById("chat-box");
                objDiv.scrollTop = objDiv.scrollHeight;

            },
            clearError(){
                this.errorMsg = '';
            },
            setErrorMsg(msg){
                this.errorMsg = msg;
            },
            initChat(){
                this.clearError();
                if(!this.name||!this.email) {
                    this.setErrorMsg('Please fill out both fields');
                    return;
                }

                this.$http.post('http://chatservice.dev/api/person', {
                    name: this.name,
                    email: this.email
                })
                .then(response =>{
                    this.currentPersonId = response.body.data.id;
                    this.$cookie.set('person', this.currentPersonId, 1);
                    this.$http.post('http://chatservice.dev/api/chat')
                        .then(response =>{
                                this.chatId = response.body.data.id;
                                this.$cookie.set('chat', this.chatId, 1);
                                this.reloadChat();

                        }, error => {
                            //@todo error handling?
                            console.log(error.body.message);
                        });
                    }, error => {
                        //@todo error handling?
                        this.setErrorMsg(error.body.message);
                    });





            },
            getChat(){
                var $this = this;

                this.$http.get('http://chatservice.dev/api/chat/' + this.chatId)
                    .then(response =>{
                            this.messages = response.data.data;
                            setTimeout(function(){
                                this.scrollBottom();
                            }.bind(this),1); // push to the bottom of the execution stack
                        }, error => {
                            //@todo error handling?
                            console.log(error);
                        });

            },
            validateChat(){
                //@todo validate cookies
            },
            isUser(person){
                this.messagePerson = false;
                if(user === this.currentPersonId){
                    this.messagePerson = true;
                }

            },
            submitChat(){
            var chatMessage = this.currentChatMessage;
            this.currentChatMessage = '';
                this.$http.post('http://chatservice.dev/api/chatMessage',
                            {
                                chat_id: this.chatId,
                                person_id: this.currentPersonId,
                                message: chatMessage
                            })
                            .then(response =>{
                                  this.getChat();
                                }, error => {
                                    //@todo error handling?
                                    console.log(error);
                                });
            },
            reloadChat(){
                if (!this.reloadChatTimer) {
                    this.reloadChatTimer = setInterval(function(){
                            this.getChat();
                        }.bind(this), 5000);
                }
            }



        }


}





</script>