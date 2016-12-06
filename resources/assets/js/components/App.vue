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
            <chat-message-wrap :messages="messages"></chat-message-wrap>
        </div>
    </div>
</template>

<script>

    import {dataBus} from "../app";

    export default {
        data(){
            return {
                chatId: dataBus.chatId,


            };

        },

        created(){

            dataBus.chatId = this.$cookie.get('chat');
            dataBus.currentPersonId = this.$cookie.get('person');
            this.chatId = dataBus.chatId;
            dataBus.$emit('registeredChat');

            dataBus.$on('registeredChat', function() {
                this.chatId = dataBus.chatId;
            }.bind(this));
        }

    }



</script>