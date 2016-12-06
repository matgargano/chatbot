<style scoped>
.user{
    font-size: 14px;
    margin: -4px;
    border-right: 3px solid #60DF88 !important;
    padding: 5px;
    background-color: rgb(239, 255, 241);
    float:right;
}

.admin{
    font-size: 14px;
    margin: -4px;
    border-left: 3px solid rgb(255, 112, 0) !important;
    padding: 5px;
    padding-left:10px;
    background-color: rgb(247, 247, 214);
    float:left;
}


</style>
<template>

    <blockquote
            :class="[{admin: message.person.id != currentPersonId}, {user:  message.person.id == currentPersonId}]">
        {{ message.person.name }} - {{ message.message }}<br>
        {{ message.created_at }}
    </blockquote>
</template>
<script>
    export default {

        props: ['message', 'currentPersonId'],


    }




</script>