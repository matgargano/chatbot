<template>
    <div>
        <div class="error" v-if="errorMsg">
            {{ errorMsg }}
        </div>
        <label for="name">Email <input @keyup.enter="setChatData" id="email" type="email" v-model="email"></label>
        <label for="name">Name <input @keyup.enter="setChatData" id="name" type="text" v-model="name"></label>
        <button class="btn btn-primary" @click="setChatData">+</button>
    </div>
</template>
<script>
    import {dataBus} from "../app";

    export default {

        data(){
           return {
                email: '',
                name: '',
                errorMsg: '',
                currentPersonId: '',
                chatId: ''

            }

        },

        methods: {

            clearError(){
                this.errorMsg = '';
            },
            setErrorMsg(msg){
                this.errorMsg = msg;
            },
            setChatData(){
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
                                dataBus.$emit('registeredChat', this.chatId, this.currentPersonId);

                        }, error => {
                            //@todo error handling?
                            console.log(error.body.message);
                        });
                    }, error => {
                        //@todo error handling?
                        this.setErrorMsg(error.body.message);
                    });





            }




        }


}


</script>