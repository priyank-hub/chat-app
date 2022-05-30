<template>
    <Layout :user="user">
        <div class="row mx-0 justify-content-center align-items-center" style="min-height: 90vh; background-color: #4825a9;">
            <div class="col-12 col-md-7">
                <div class="card bg-white rounded py-3">
                    <h3 class="mb-0">{{ chatData.room.name }}</h3>
                    <hr>
                    <div id="chatbox" style="height: 40vh; overflow: auto; scroll-behavior: smooth;" class="pt-0 mb-3">
                        <div v-for="(message,index) in messages" :key="index" class="my-2">
                            <div v-if="message.join" class=" text-center">
                                <span class="text-muted">
                                    {{ message.user.name }} has joined the chat
                                </span>
                            </div>

                            <div v-else-if="message.leave" class=" text-center">
                                <span class="text-muted">
                                    {{ message.user.name }} has left the chat
                                </span>
                            </div>
                            
                            <div v-else class="d-flex" :class="message.user.id === user.id ? 'text-right flex-row-reverse' : 'text-left flex-row'">
                                <div class="mx-1">
                                    <b-avatar :text="message.user.name.substring(0,1) + message.user.name.substring(0,1)" style="background-color: #222; color: white"></b-avatar>
                                </div>
                                <div class="border p-2 message">
                                    {{ message.message }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <input
                        @keyup.enter="sendMessage"
                        @keydown="whisper"
                        v-model="newMessage"
                        type="text"
                        name="message"
                        placeholder="Enter your message..."
                        class="form-control"
                    >
                </div>
            </div>
        </div>
    </Layout>
</template>
<script>
import Layout from '../Shared/Layout'
export default {
    components: {
        Layout,
    },
    props: {
        chatData: Object,
        user: Object,
    },
    data() {
        return {
            newMessage: '',
            messages: this.chatData.messages,
        }
    },
    mounted() {
        Echo.join(`chat.room.${this.chatData.room.id}`)
        .here((users) => {
            console.log('here', users);
        })
        .joining((user) => {
            console.log('joining...', user);
            this.messages.push({
                user: user,
                message: null,
                join: true,
            });

            this.scrollDiv();
        })
        .leaving((user) => {
            console.log('leaving...', user);
            this.messages.push({
                user: user,
                message: null,
                leave: true,
            });

            this.scrollDiv();
        })
        .error((error) => {
            console.log("echo:error", error);
        })
        .listen('.chat-user', (e) => {
            console.log('pingg');
            this.messages.push({
                user: e.user,
                message: e.message,
            });

            this.scrollDiv();
        })
        .listenForWhisper('typing', (user) => {
            console.log(user.name + ' is typing');
            // this.setState({ typingUser: user });

            // if (this.state.typingTimer) {
            //     clearTimeout(this.state.typingTimer);
            // }

            // this.setState({
            //     typingTimer: setTimeout(() => {
            //         this.setState({ typingUser: null });
            //     }, 3000),
            // });
        });
    },
    methods: {
        sendMessage() {
            var element = document.getElementById("chatbox");
            console.log('original ', element.scrollHeight, element.clientHeight)
            axios.post(route('message', this.chatData.room.id), {
                message: this.newMessage,
            })
            .then((res) => {
                if (res.data.status === 'success') {  
                    this.messages.push({
                        user: this.user,
                        message: this.newMessage
                    });
                    this.newMessage = '';

                    this.scrollDiv();
                }
            });
        },
        scrollDiv() {
            setTimeout(function() {
                var elem = document.getElementById('chatbox');
                elem.scrollTop = elem.scrollHeight;
            }, 500);
        },
        whisper() {
            console.log('whispering')
            Echo.join(`chat.room.${this.chatData.room.id}`)
            .whisper('typing', {
                user: this.user,
                typing: true,
            })
        }
    }
}
</script>
<style>
.text-left {
    text-align: left;
}

.text-right {
    text-align: right;
}

.float-left {
    float: left;
}

.float-right {
    float: right;
}

.message {
    background-color: #4825a9;
    color: white;
    border-radius: 10px;
    display: inline-block;
    max-width: 50%;
}

/* .message::before {
    content: '';
    position: relative;
    bottom: -30%;
    border-top: 6px solid rgba(0, 0, 0, .3);
    left: 20px;
    border-right: 7px solid transparent;
} */
</style>
