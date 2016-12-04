<style scoped>
.user{
    font-size: 14px;
    margin: -4px;
    border-right: 3px solid #60DF88 !important;
    padding: 5px;
    background-color: rgb(239, 255, 241);
}

.admin{
    font-size: 14px;
    margin: -4px;
    border-left: 3px solid rgb(255, 112, 0) !important;
    padding: 5px;
    padding-left:10px;
    background-color: rgb(247, 247, 214);
}

.chat-window {
    width:300px;
}




</style>
<template>
    <div>

        <div v-if="!chatId">
            <label for="name">Email <input id="email" type="email" v-model="email"></label>
            <label for="name">Name <input id="name" type="name" v-model="name"></label>
            <button class="btn btn-primary" @click="initChat">+</button>
        </div>
        <div v-else>


            <div class="chat-window">
                <div class="panel panel-primary">
                    <div class="panel-heading"> Support
                        <small v-if="online">online</small>
                        <small v-else>offline</small>
                    </div>


                    <div class="messages" v-for="message in messages">
                        <div class="panel-body">
                            <div class="clearfix">
                                <blockquote class="pull-right" :class="[{admin: message.person_id != personId}, {user:  message.person_id == personId}]">{{ message.message }}</blockquote>
                            </div>
                        </div>
                    </div>
                    <input type="text" v-model="currentChatMessage" @keyup.enter="submitChat">
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    export default {

        data(){
           return {
                chatId: '',
                messages: [],
                personId: '',
                email: '',
                name: '',
                online: true,
                messagePerson: false,
                currentChatMessage: ''
            }

        },
        created(){
            this.chatId = this.$cookie.get('chat');
            this.personId = this.$cookie.get('person');
            this.validateChat();
            if(this.chatId && this.personId){
                this.getChat();
            }
        },
        methods: {
            initChat(){
                this.$http.post('http://chatservice.dev/api/person', {
                    name: this.name,
                    email: this.email
                })
                .then(response =>{
                    this.personId = response.body.data.id;
                    this.$cookie.set('person', this.personId, 1);
                    this.$http.post('http://chatservice.dev/api/chat')
                        .then(response =>{
                                this.chatId = response.body.data.id;
                                this.$cookie.set('chat', this.chatId, 1);

                        }, error => {
                            //@todo error handling?
                            console.log(error);
                        });
                    }, error => {
                        //@todo error handling?
                        console.log(error);
                    });



            },
            getChat(){
                this.$http.get('http://chatservice.dev/api/chatMessage', {params:  {id: this.chatId}})
                    .then(response =>{
                            this.messages = response.data.data;
                        }, error => {
                            //@todo error handling?
                            console.log(error);
                        });

            },
            validateChat(){
                //@todo validate cookies
            },
            isUser(person){
                this.messagePerson = false;
                if(user === this.personId){
                    this.messagePerson = true;
                }

            },
            submitChat(){
                this.$http.post('http://chatservice.dev/api/chatMessage',
                            {
                                chat_id: this.chatId,
                                person_id: this.personId,
                                message: this.currentChatMessage
                            })
                            .then(response =>{

                                }, error => {
                                    //@todo error handling?
                                    console.log(error);
                                });
            }



        }

}




















</script>

<style>
</style>
