<style scoped>
    .initial-message {
        padding:10px;
        text-align:center;
    }
    .chat-box {
        max-height:250px;
        overflow-y:auto;
    }

</style>

<template>

    <div class="chat-box" id="chat-box">
        <div class="initial-message">Chat started</div>
        <div class="message" v-for="message in messages">
            <div class="panel-body">
                <div class="clearfix">
                    <chat-message :message="message">
                    </chat-message>
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
                message:null,
                messages:[]
            };
        },
        created(){
            dataBus.$on('chatUpdated', function(messages){
                this.messages = messages;
            }.bind(this));
        }



    }








</script>