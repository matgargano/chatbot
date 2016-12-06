<style scoped>
    .error {
        color:#FF0000;
    }

</style>

<template>
    <div>
        <div class="error" v-if="errorMsg">
            {{ errorMsg }}
        </div>
        <p>To chat with a rep, enter your name & email and click the plus sign below</p>
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
                errorMsg: ''


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
                if(!this.validateEmail(this.email)){
                    this.setErrorMsg('Please set a valid email address');
                    return;
                }

                this.$http.post(dataBus.apiBase + '/people', {
                    name: this.name,
                    email: this.email
                })
                .then(response =>{
                    dataBus.currentPersonId = response.body.data.id;

                    this.$cookie.set('person', dataBus.currentPersonId, 1);
                    this.$http.post(dataBus.apiBase + '/chats')
                        .then(response =>{
                                dataBus.chatId = response.body.data.id;

                                this.$cookie.set('chat', dataBus.chatId, 1);
                                dataBus.$emit('registeredChat');

                        }, error => {
                            //@todo error handling?
                            console.log(error);
                        });
                    }, error => {

                        //@todo error handling?
                        this.setErrorMsg(error.body.message);
                    });





            },
            validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }





        }


}


</script>