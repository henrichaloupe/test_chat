<template>
    <div>
        <h3 class="mb-4">Chat</h3>
        <div class="card">
            <div class="card-body">
                <NewMessageForm @newMessage="newMessage" />
                <ul>
                    <li v-for="message in messages">
                        {{ message.created_at }} => {{ message.user.name }} : {{ message.message }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import {api} from "../../config";
    import {mapActions} from 'vuex';
    import axios from 'axios';
    import Echo from 'laravel-echo'
    import Pusher from "pusher-js"
    import NewMessageForm from "./NewMessageForm";

    window.io = require('socket.io-client');


    export default {
        data () {
            return {
                messages: [],
            }
        },
        mounted: function() {
            axios
                .get(api.message)
                .then(response => (this.messages = response.data))

            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: '868e911a5b37acf6f826',
                cluster: 'eu'
            });


            window.Echo.channel('my-channel')
                .listen('.new-message', (data) => {
                    this.newMessage(data.message);
                });
        },
        components: {
            NewMessageForm: NewMessageForm
        },
        methods: {
            newMessage: function (message) {
                const messages = this.messages;
                messages.unshift(message)
                this.messages = messages.slice(0,10);
            }
        }
    }
</script>
