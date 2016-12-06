<style scoped>
    .initial-message {
        padding:10px;
        text-align:center;
    }

</style>

<template>

    <div>

        <div class="initial-message">Chat started</div>
        <div class="message" v-for="message in messages">
            <div class="panel-body">
                <div class="clearfix">

                    <chat-message :message ="message" :currentPersonId="currentPersonId">
                    </chat-message>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                message: ''
            }
        },

        props: ['messages', 'currentPersonId']

    }



</script>