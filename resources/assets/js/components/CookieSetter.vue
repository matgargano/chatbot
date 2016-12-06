<style scoped>

</style>

<template>
    <div>
        <div v-if="success" class="alert alert-success">
            <strong>Success, reloading...</strong>
        </div>
        <p>Set cookies here. An easy way to test this out is to either create your own chat by signing up below ... or set personId to 1 and chatId to 1 in this page, and then personId to 2 and chatId to 1 in another browser (or incognito). Setting/Clearing cookies will trigger a reload</p>
        <label for="personId">PersonId <input @keyup.enter="setPersonId" id="personId" type="text"
                                              v-model="personId"></label>
        <label for="chatId">ChatId <input @keyup.enter="setChatId" id="chatId" type="text" v-model="chatId"></label>
        <button class="btn btn-primary" @click="setCookies">Set Cookies</button>
        <button class="btn btn-primary" @click="clearCookies">Clear Cookies</button>

    </div>
</template>
<script>


    export default {

        data(){
           return {
                personId: this.$cookie.get('person'),
                chatId: this.$cookie.get('chat'),
                success: false,
                cookieName: ''



            }

        },

        methods: {

            setCookies(){
                this.$cookie.set('person', this.personId);
                this.$cookie.set('chat', this.chatId);
                this.setSuccess();
            },
            clearCookies() {
                this.$cookie.set('person', '');
                this.$cookie.set('chat', '');
                this.setSuccess();
            },

            setSuccess(){

                this.success = true;
                setTimeout(function(){
                    this.success = false;
                    location.reload();
                }.bind(this), 1500);
            }




        }


}



</script>