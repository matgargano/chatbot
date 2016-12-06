<style scoped>
    .chat-window {
        width:300px;
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


                    <chat-message-wrap :messages="messages"></chat-message-wrap>

                    <chat-message-input></chat-message-input>
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
                chatId: null,
                online: null,

            };

        },

        created(){

            dataBus.chatId = this.$cookie.get('chat');
            dataBus.currentPersonId = this.$cookie.get('person');
            this.online = dataBus.online;
            this.chatId = dataBus.chatId;
            dataBus.$emit('registeredChat');
        }

    }


</script>