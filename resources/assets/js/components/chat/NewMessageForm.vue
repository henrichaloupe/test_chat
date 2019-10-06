<template>
    <div>
        <input type="text" v-model="content" />
        <button v-on:click="send">Send</button>
    </div>
</template>

<script>
    import axios from 'axios';
    import {api} from "../../config";


    export default {
        data () {
            return {
                content: '',
            }
        },
        methods: {
            send: function() {
                axios
                    .post(api.message, {
                        message: this.content
                    })
                    .then(response => {
                        this.$emit('newMessage', response.data);
                        this.$noty.success('Send!')
                    })
                    .catch(response => this.$noty.error('Error!'))
            }
        }
    }
</script>

<style scoped>

</style>