<template>
    <div class="container">
        <h1>Inertiajs is {{ test }}</h1>

        <Link href="/about-us">Go to about us</Link> <br>
        <a href="/login">Go to Login</a>

        <div class="row">
            <div class="col-8">
                    <div class="card card-default">
                    <div class="card-header">Messages</div>
                        <div class="card-body p-0">
                            <ul class="list-unstyled" style="height:300px; overflow-y:scroll">
                                <li class="p-2" v-for="(message, index) in messages" :key="index" >
                                    <div class="text-center" v-if="viewers.length > 0">
                                        <span class="text-muted">
                                            {{ joinedUser.name }} has joined the chat
                                        </span>
                                    </div>
                                    <strong>{{ message.user.name }}</strong>
                                    {{ message.message }}
                                </li>
                            </ul>
                        </div>

                        <input
                        @keyup.enter="sendMessage"
                        v-model="newMessage"
                        type="text"
                        name="message"
                        placeholder="Enter your message..."
                        class="form-control">
                    </div>
                    <!-- <span class="text-muted" v-if="activeUser" >{{ activeUser.name }} is typing...</span> -->
            </div>

            <!-- <div class="col-4">
                <div class="card card-default">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <ul>
                            <li class="py-2" v-for="(user, index) in users" :key="index">
                                {{ user.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    components: {
        Link,
    },
    props: {
        test: String,
        user: Object,
    },
    data() {
        return {
            messages: [],
            newMessage: '',
            viewers: [],
            joinedUser: null,
            leavedUser: null,
        }
    },
    mounted() {
        this.fetchMessages();
        
        Echo.channel('chat')
        .listen('.chat-user', (data) => {
            console.log('listening', data);
            this.messages.push(data.chat);
        });

        Echo.join('chat')
        .here((users) => {
            console.log(users)
        })
        .joining((user) => {
            this.viewers.push(user);
        })
        .leaving(user => {
            console.log('leaving...', user);
        });

        // Echo.join('chat')
        // .here(user => {
        //     console.log('channel connected');
        // })
        // .joining(user => {
        //     // this.users.push(user);
        // })
        // .leaving(user => {
        //     // this.users = this.users.filter(u => u.id != user.id);
        // })
        // .listen('ChatEvent',(event) => {
        //     this.messages.push(event.chat);
        // })
        // .listenForWhisper('typing', user => {
        //     // this.activeUser = user;
        //     // if(this.typingTimer) {
        //     //     clearTimeout(this.typingTimer);
        //     // }
        //     // this.typingTimer = setTimeout(() => {
        //     //     this.activeUser = false;
        //     // }, 1000);
        // })
    },
    methods: {
        fetchMessages() {
            axios.get('messages').then(response => {
                this.messages = response.data;
            })
        },
        sendMessage() {
            this.messages.push({
                user: this.user,
                message: this.newMessage
            });
            axios.post('messages', {message: this.newMessage});
            this.newMessage = '';
        },
        setJoin(user) {
            console.log('joineddd', user);
            this.joinedUser = user;
            console.log(this.joinedUser);
        }
    }
};
</script>