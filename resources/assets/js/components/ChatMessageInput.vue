<style scoped>
.chat-input {
    padding:5px;
    width:100%;
}

</style>
<template>
    <div>
        <input class="chat-input" type="text" v-model="currentChatMessage" @keyup.enter="submitChat">
    </div>
</template>
<script>

    import {dataBus} from "../app";

    export default {

        data(){
           return {

                currentChatMessage: ''



            }

        },

        methods: {





            submitChat(){
                var chatMessage = this.currentChatMessage;
                this.currentChatMessage = '';
                    this.$http.post('http://chatservice.dev/api/chatMessages',
                                {
                                    chat_id: dataBus.chatId,
                                    person_id: dataBus.currentPersonId,
                                    message: chatMessage
                                })
                                .then(response =>{

                                    }, error => {
                                        //@todo error handling?
                                        console.log(error);
                                    });
            },




        }


}

</script>