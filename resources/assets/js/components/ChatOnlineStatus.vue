<style scoped>
    .offline {
        background:red;
    }
</style>

<template>
    <div class="panel-heading" :class="{offline: !online}"> Support
        <small v-if="online">online</small>
        <small v-else>offline</small>
        <small v-if="polling">Polling</small>
        <small v-else>Not Polling, check your cookies!</small>
    </div>

</template>
<script>

    import {dataBus} from "../app";

    export default {
        data(){
            return {
                polling: dataBus.polling,
                online: true, // set to false and heading becomes red

            };

        },
        created(){
            dataBus.$on('pollingUpdate', function(active){
                this.polling = dataBus.polling;
                if(!active) {
                    this.online = false;
                }
            }.bind(this));
        },
        methods: {
            online(){
                // check if online using http request and a RESTful endpoint to be created
            }
        }

    }

</script>