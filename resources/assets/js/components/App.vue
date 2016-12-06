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
            <new-chat-module></new-chat-module>
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

    import {dataBus} from "../app";


    export default {

        data(){
           return {
                chatId: '',
                messages: [],
                currentPersonId: '',
                online: true, // this can be modified
                messagePerson: false,
                currentChatMessage: '',
                reloadChatTimer: null,


            }

        },
        created(){


            dataBus.$on('registeredChat', (chatId, currentPersonId) =>{
                this.chatId = chatId;
                this.currentPersonId = currentPersonId;
                this.startChat(this.chatId, this.currentPersonId);
            });

            this.chatId = this.$cookie.get('chat');
            this.currentPersonId = this.$cookie.get('person');
            dataBus.$emit('registeredChat', this.chatId, this.currentPersonId);



        },
        methods: {

            scrollBottom(){
                var objDiv = document.getElementById("chat-box");
                objDiv.scrollTop = objDiv.scrollHeight;

            },
            getChat(){
                //var $this = this;

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
            startChat(chatId, currentPersonId){

                this.chatId = chatId;
                this.currentPersonId = currentPersonId;

                if(this.validateChat()){
                    this.getChat();
                    this.reloadChat();

                }

            },
            validateChat(){
                if (this.validateCookies() && this.validateChatData()){
                    return true;
                }
                return false;

            },

            validateCookies(){
                //@todo validate cookie data that person is correct

                return true;
            },
            validateChatData(){

                 return this.chatId && this.currentPersonId;

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