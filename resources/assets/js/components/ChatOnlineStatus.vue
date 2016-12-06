<style scoped>
    .offline {
        background:red;
    }
</style>

<template>
    <div class="panel-heading" :class="{offline: !online}"> Support
        <small v-if="online">online</small>
        <small v-else>offline</small>
    </div>

</template>
<script>

    import {dataBus} from "../app";

    export default {
        data(){
            return {

                online: true, // set to false and heading becomes red

            };

        },

        methods: {
            online(){
                // check if online using http request and a RESTful endpoint to be created
            }
        }

    }

</script>