<template>
    <Layout :user="user">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center" style="min-height: 90vh; background-color: #7615a5;">
                <div class="col-12 col-md-4">
                    <div class="card bg-white p-3">
                        <h3 class="mb-0">Rooms</h3>
                        <hr>
                        <div class="my-3" style="max-height: 500px; overflow: auto">
                            <div v-for="room in rooms" :key="room.id" class="border p-2 rounded my-2">
                                <Link :href="route('chat', room.id)" class="text-dark" style="text-decoration: none">
                                    <div class="row justify-content-between mx-0">
                                        <div class="col text-left">
                                            {{ room.name }}
                                        </div>
                                        <div class="col-1 text-right">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="container my-4">
            <div class="row">
                <div class="col-12 col-md-3 col-lg-4">
                    <div class="border rounded p-3">
                        <div v-for="room in rooms" :key="room.id" class="border p-2 rounded m-3" @click="changeRoom(room)" style="cursor: pointer">
                            <div class="row justify-content-between mx-0">
                                <div class="col text-left">
                                    {{ room.name }}
                                </div>
                                <div class="col-1 text-right">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-9 col-lg-8">
                    <div>
                        <ChatBox :currentRoom="currentRoom" :user="user"/>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card card-default">
                        <div class="card-header">Users</div>
                        <div class="card-body">
                            <ul>
                                <li class="py-2" v-for="(user, index) in users" :key="index">
                                    {{ user.name }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
    
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
                </div>
            </div>
        </div> -->
    </Layout>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Layout from '../Shared/Layout'
export default {
    components: {
        Link,
        Layout,
    },
    props: {
        test: String,
        user: Object,
        users: Array,
        rooms: Array,
        chatData: Object,
    },
    data() {
        return {
            messages: [],
            newMessage: '',
            viewers: [],
            joinedUser: null,
            leavedUser: null,
            currentRoom: this.chatData,
        }
    },
    mounted() {
        
    },
    methods: {
        changeRoom(room) {
            console.log(room)
            
            this.$inertia.reload();

            axios.get(
                route('chat', room.name)
            )
            .then((response) => {
                console.log(response);
                if (response.status === 200) {
                    this.currentRoom = response.data.chatData;
                }
            });
        },
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
<style>
.text-right {
    text-align: right;
}
</style>