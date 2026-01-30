@include('navbar')
@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
    }

    /* الحاوية الرئيسية - جعلتها مرنة لتناسب المتصفح */
    .chat-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 100px); /* يطرح ارتفاع النافبار التقريبي */
        padding: 20px;
    }

    .chat-container {
        font-family: 'Poppins', sans-serif;
        background-color: #003366;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        width: 100%;
        max-width: 900px; /* عرض الدردشة القياسي */
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
    }

    /* رأس الدردشة */
    .chat-header {
        padding: 15px 20px;
        background: rgba(0, 0, 0, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* منطقة الرسائل */
    #chatBox {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background: #003366; /* الحفاظ على الثيم الأزرق */
    }

    /* تنسيق الرسائل العام */
    .message-row {
        display: flex;
        width: 100%;
        margin-bottom: 5px;
    }

    .bubble {
        max-width: 75%;
        padding: 12px 16px;
        font-size: 14px;
        line-height: 1.4;
        position: relative;
    }

    /* رسالة الطرف الآخر */
    .message-row.other {
        justify-content: flex-start;
    }

    .message-row.other .bubble {
        background: #ffffff;
        color: #333;
        border-radius: 18px 18px 18px 2px;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
    }

    /* رسالتي أنا */
    .message-row.me {
        justify-content: flex-end;
    }

    .message-row.me .bubble {
        background: #ff8c55; /* البرتقالي */
        color: #fff;
        border-radius: 18px 18px 2px 18px;
        box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
    }

    .message-time {
        font-size: 10px;
        opacity: 0.7;
        margin-top: 5px;
        display: block;
        text-align: right;
    }

    /* منطقة الإدخال */
    .input-area {
        padding: 15px 20px;
        background: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-input {
        flex: 1;
        padding: 12px 18px;
        border-radius: 25px;
        border: 1px solid #ddd;
        outline: none;
        font-size: 14px;
        transition: border 0.3s;
    }

    .chat-input:focus {
        border-color: #ff8c55;
    }

    .send-btn {
        background: #ff8c55;
        color: white;
        border: none;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .send-btn:hover {
        background: #e07b4a;
        transform: scale(1.05);
    }

    /* مخصص للشاشات الصغيرة */
    @media (max-width: 768px) {
        .chat-wrapper {
            padding: 0;
            height: calc(100vh - 60px);
        }
        .chat-container {
            border-radius: 0;
        }
        .bubble {
            max-width: 85%;
        }
    }

    /* Avatar صغير هادئ */
    .mini-avatar {
        width: 35px;
        height: 35px;
        background: #eee;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #003366;
        font-size: 14px;
    }
</style>

<div class="chat-wrapper" x-data="chatApp()" x-init="init()">
    <div class="chat-container">
        <div class="chat-header">
            <div class="user-info">
                <div class="mini-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h3 style="margin:0; font-size:15px;">{{ $otherUser->name }}</h3>
                    <div style="font-size:11px; opacity:0.8;">
                        <span x-text="status"></span>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <i class="fas fa-ellipsis-v" style="cursor:pointer; opacity:0.7;"></i>
            </div>
        </div>

        <div id="chatBox">
            <div class="message-row other">
                <div class="bubble">
                    Welcome, {{ auth()->user()->name }}.<br>
                    How can we help you today?
                    <span class="message-time">System</span>
                </div>
            </div>

            <template x-for="msg in messages" :key="msg.id">
                <div class="message-row" :class="Number(msg.sender_id) === authId ? 'me' : 'other'">
                    <div class="bubble">
                        <span x-text="msg.message"></span>
                        <span class="message-time" x-text="new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })"></span>
                    </div>
                </div>
            </template>
            
            <div x-show="loading" style="text-align:center; color:rgba(255,255,255,0.5); font-size:12px;">
                <i class="fas fa-circle-notch fa-spin"></i> Loading...
            </div>
        </div>

        <div class="input-area">
            <input 
                x-model="newMessage" 
                @keydown.enter="sendMessage()"
                type="text" 
                class="chat-input" 
                placeholder="Write a message..."
                :disabled="sending"
            >
            <button class="send-btn" @click="sendMessage()" :disabled="!newMessage.trim() || sending">
                <i class="fas fa-paper-plane" x-show="!sending"></i>
                <i class="fas fa-spinner fa-spin" x-show="sending"></i>
            </button>
        </div>
    </div>
</div>

<script>
// (نفس كود الـ JavaScript الخاص بك دون تغيير في المنطق، فقط أضفت لمسات بسيطة للتمرير)
function chatApp() {
    return {
        authId: {{ (int) auth()->id() }},
        otherUserId: {{ (int) $otherUser->id }},
        messages: [],
        newMessage: '',
        loading: true,
        sending: false,
        status: 'Connecting...',
        echoChannel: null,

        init() {
            this.loadMessages();
            setTimeout(() => this.setupRealtime(), 1000);
        },

        scrollToBottom() {
            const chatBox = document.getElementById('chatBox');
            if(chatBox) {
                setTimeout(() => {
                    chatBox.scrollTo({ top: chatBox.scrollHeight, behavior: 'smooth' });
                }, 100);
            }
        },

        async loadMessages() {
            try {
                const res = await window.axios.get(`/chat/${this.otherUserId}/messages`);
                this.messages = res.data.messages || [];
                this.scrollToBottom();
                this.status = 'Online';
            } catch (error) {
                this.status = 'Offline';
            } finally {
                this.loading = false;
            }
        },

        async sendMessage() {
            const text = this.newMessage.trim();
            if (!text || this.sending) return;

            this.sending = true;
            try {
                const res = await window.axios.post(`/chat/${this.otherUserId}/messages`, { message: text });
                const newMsg = res.data.message;
                this.messages.push(newMsg);
                this.newMessage = '';
                this.scrollToBottom();
            } catch (error) {
                alert('Failed to send message');
            } finally {
                this.sending = false;
            }
        },

        setupRealtime() {
            if (!window.Echo) return;
            window.Echo.private(`chat.${this.authId}`)
                .listen('.message.sent', (e) => {
                    if (Number(e.message.sender_id) !== Number(this.authId)) {
                        this.messages.push(e.message);
                        this.scrollToBottom();
                    }
                });
        }
    }
}
</script>

@include('footer')
@endsection