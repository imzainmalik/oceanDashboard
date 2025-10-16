@extends('layouts.app')
@section('content')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Small visual polish */
        body {
            background: #f6f7fb;
        }

        .inbox-container {
            height: calc(100vh - 3.5rem);
        }

        /* leave room for top nav if any */
        .folders {
            background: #fff;
            border-radius: .5rem;
            padding: .75rem;
        }

        .message-list {
            background: #fff;
            border-radius: .5rem;
            height: 100%;
            overflow: auto;
        }

        .message-item {
            cursor: pointer;
            border-bottom: 1px solid #f1f3f6;
            padding: .75rem;
        }

        .message-item:hover {
            background: #f8fbff;
        }

        .message-item.unread .subject {
            font-weight: 600;
        }

        .message-preview {
            background: #fff;
            border-radius: .5rem;
            height: 100%;
            overflow: auto;
            padding: 1rem;
        }

        .message-meta {
            font-size: .9rem;
            color: #6b7280;
        }

        .small-muted {
            font-size: .85rem;
            color: #6b7280;
        }

        .compose-btn {
            width: 100%;
        }

        .no-select {
            user-select: none;
        }

        @media (max-width: 991px) {
            .message-preview {
                display: none;
            }

            /* hide preview on small screens by default */
            .message-preview.show-sm {
                display: block;
                position: absolute;
                top: 4rem;
                right: .75rem;
                left: .75rem;
                bottom: .75rem;
                z-index: 1050;
            }
        }

        .chat-msg {
            margin: 4px 0;
        }

        .bg-light {
            background: #f8f9fa !important;
        }

        .message {
            margin: 5px 0;
            display: flex;
        }

        .sent {
            justify-content: flex-end;
        }

        .received {
            justify-content: flex-start;
        }

        .my-msg {
            background-color: #d1f5d3;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 70%;
        }

        .their-msg {
            background-color: #f1f1f1;
            padding: 8px 12px;
            border-radius: 10px;
            max-width: 70%;
        }
    </style>
    <div class="container-fluid py-3">
        <div class="row gx-3 inbox-container">
            <!-- LEFT: Folders -->
            <aside class="col-lg-3 col-xl-3 d-flex flex-column gap-3">
                <div class="folders p-3 shadow-sm">
                    @if ($chat_room == null)
                        <a href="{{ route('message.create_chat_room') }}" class="btn btn-primary compose-btn mb-2">Create
                            family chat room</a>
                    @else
                        <a href="{{ route('message.family_chat', $chat_room->room_id) }}"
                            class="btn btn-primary compose-btn mb-2">Access family chat room</a>
                    @endif
                    <a href="javascript:;" class="btn btn-primary compose-btn mb-2" data-toggle="modal"
                        data-target="#exampleModal">Compose new message</a>

                    <div class="list-group mb-3">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-header"><strong>Contact list</strong></div>
                                <ul id="conversationList" class="list-group list-group-flush"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="composeMessageContainer">
                                <select id="selectUser">
                                    <option value="">Select User</option>
                                    @foreach ($family_members as $family_member)
                                        <option value="user_id_{{ $family_member->id }}">{{ $family_member->name }}</option>
                                    @endforeach
                                    <!-- Dynamically generate this from Firebase if needed -->
                                </select>
                                <textarea id="newMessage" placeholder="Type your message..." rows="3"></textarea>
                                <button id="sendMessageBtn">Send</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CENTER: Message list -->
            <main class="col-lg-6 col-xl-6 d-flex flex-column">

                <div class="message-list shadow-sm">
                    <!-- toolbar -->
                    <div id="messagesContainer">
                        <!-- example message items -->

                        <!-- empty-state -->
                        <div id="emptyState" class="text-center text-muted py-5" style="display:none;">
                            No messages found.
                        </div>
                    </div>

                    <!-- messages -->
                    <div id="messagePreview" class="message-preview shadow-sm">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 id="previewSubject">Select a message to start messaging</h5>
                                <div class="message-meta" id="previewFrom">—</div>
                            </div>
                        </div>

                        <hr>

                        <div id="previewBody" class="mb-3 small-muted">
                            Click any message on the left to read its contents.
                        </div>

                        <div class="small-muted">

                            <ul id="previewAttachments" class="list-unstyled mb-0">
                                <!-- attachments -->
                            </ul>
                        </div>

                    </div>

                </div>
            </main>

            <!-- RIGHT: Preview pane -->
            <aside class="col-lg-3 col-xl-3 shadow-sm">


                @foreach ($latestFour as $item)
                    <div class="message-item d-flex align-items-start mb-3">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="subject">{{ $item['title'] }}</div>
                                    <div class="small text-muted">Category: {{ $item['type'] }}</div>
                                </div>
                                <div class="text-end small-muted">
                                    <div>{{ \Carbon\Carbon::parse($item['date'])->format('M j, g:i A') }}</div>
                                    <div><span class="badge bg-{{ $item['badge'] }}">{{ $item['type'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </aside>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-app.js";
        import {
            getDatabase,
            ref,
            onValue,
            push,
            set,
            get
        } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-database.js";
        import {
            getStorage
        } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-storage.js";

        // 🔹 Firebase Config
        const firebaseConfig = {
            apiKey: "AIzaSyBBC2zLE2PeBe0dErhr74EfE1Q07mzWzHs",
            authDomain: "bridgeline-54be0.firebaseapp.com",
            projectId: "bridgeline-54be0",
            storageBucket: "bridgeline-54be0.firebasestorage.app",
            messagingSenderId: "227803086615",
            appId: "1:227803086615:web:308289f10be9063b5b0152",
            measurementId: "G-JRS6Z5FWBZ"
        };

        const app = initializeApp(firebaseConfig);
        const db = getDatabase(app);
        const storage = getStorage(app);

        // 🔹 Current user
        const currentUserId = "{{ auth()->user()->id }}";
        const currentUserName = "{{ auth()->user()->name }}";

        // 🔹 UI Elements
        const selectUser = document.getElementById("selectUser");
        const newMessageInput = document.getElementById("newMessage");
        const sendMessageBtn = document.getElementById("sendMessageBtn");
        const messagesContainer = document.getElementById("conversationList");
        const previewSubject = document.getElementById("previewSubject");
        const previewBody = document.getElementById("previewBody");

        let activeConvId = null;

        // =================================================
        // 🔹 Fetch all conversations (real-time)
        // =================================================
        const conversationsRef = ref(db, "conversations");

        onValue(conversationsRef, (snapshot) => {
            messagesContainer.innerHTML = "";
            const data = snapshot.val();
            if (!data) {
                messagesContainer.innerHTML =
                    '<div class="text-center text-muted py-5">No conversations found.</div>';
                return;
            }

            let conversationsList = [];

            Object.keys(data).forEach((convId) => {
                const conv = data[convId];
                if (conv.participants && conv.participants.sender_id) {
                    const messages = conv.messages || {};
                    let lastMsg = null;

                    Object.values(messages).forEach(userMsgs => {
                        Object.values(userMsgs).forEach(m => {
                            if (!lastMsg || m.timestamp > lastMsg.timestamp) lastMsg = m;
                        });
                    });

                    conversationsList.push({
                        id: convId,
                        lastMsg: lastMsg,
                        participants: conv.participants
                    });
                }
            });

            // Sort latest on top
            conversationsList.sort((a, b) => {
                const timeA = a.lastMsg ? a.lastMsg.timestamp : 0;
                const timeB = b.lastMsg ? b.lastMsg.timestamp : 0;
                return timeB - timeA;
            });

            // Render list
            conversationsList.forEach(conv => {
                $.ajax({
                    type: "GET",
                    url: '{{ route('message.index') }}?sender_id=' + conv.participants.sender_id +
                        '&receiver_id=' + conv.participants.reciever_id,
                    success: function(response) {
                        const msgDiv = document.createElement("div");
                        msgDiv.className = "border-bottom py-2 px-3 conv-item";
                        msgDiv.innerHTML =
                            `
                    <div><strong>${response.name}</strong></div>
                    <div>${conv.lastMsg ? conv.lastMsg.text : "No messages yet"}</div>
                    <div class="small text-muted">${conv.lastMsg ? new Date(conv.lastMsg.timestamp).toLocaleString() : ""}</div>`;
                        msgDiv.addEventListener("click", () => loadConversation(conv.id));
                        messagesContainer.appendChild(msgDiv);
                    }
                });
            });
        });

        // =================================================
        // 🔹 Load Conversation Messages
        // =================================================
        function loadConversation(convId) {
            activeConvId = convId;
            const chatRef = ref(db, `conversations/${convId}/messages`);
            onValue(chatRef, (snapshot) => {
                previewSubject.innerText = "Conversation";
                previewBody.innerHTML = "";
                const data = snapshot.val();

                if (!data) {
                    previewBody.innerHTML = "<p class='text-muted'>No messages yet.</p>";
                    return;
                }

                const messages = [];

                // ✅ Collect all messages into a single array
                Object.keys(data).forEach(userKey => {
                    Object.values(data[userKey]).forEach(msg => {
                        messages.push(msg);
                    });
                });

                // ✅ Sort messages by timestamp (oldest → newest)
                messages.sort((a, b) => a.timestamp - b.timestamp);

                // ✅ Clear old messages before rendering
                previewBody.innerHTML = "";

                // ✅ Render messages in proper order
                messages.forEach(msg => {
                    const div = document.createElement("div");
                    div.classList.add("message");
                    div.classList.add(msg.senderId === currentUserId ? "sent" : "received");

                    if (msg.senderId === currentUserId) {
                        div.innerHTML = `
            <div class="my-msg">
                ${msg.text}
                <div class="small text-muted">
                    ${new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                </div>
            </div>`;
                    } else {
                        div.innerHTML = `
            <div class="their-msg">
                ${msg.text}
                <div class="small text-muted">
                    ${new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                </div>
            </div>`;
                    }

                    previewBody.appendChild(div);
                });

                previewBody.scrollTop = previewBody.scrollHeight;
            });

            // ✅ Move renderInputBox() here (only once per conversation)
            renderInputBox();
        }

        // =================================================
        // 🔹 Render Message Input Box (Fixed)
        // =================================================
        function renderInputBox() {
            const existing = document.getElementById("chatInputWrapper");
            if (existing) existing.remove(); // ✅ Properly remove the old input

            const messageContainer = document.createElement("div");
            messageContainer.classList.add("mt-3");
            messageContainer.innerHTML = `
        <div class="input-group" id="chatInputWrapper">
            <input id="chatInput" type="text" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary" id="chatSendBtn">Send</button>
        </div>`;

            // ✅ Append below chat preview (not inside it)
            previewBody.parentNode.appendChild(messageContainer);

            // ✅ Add event listener
            document.getElementById("chatSendBtn").addEventListener("click", sendActiveMessage);
        }

        // =================================================
        // 🔹 Send Message in Active Conversation
        // =================================================
        function sendActiveMessage() {
            const input = document.getElementById("chatInput");
            const text = input.value.trim();
            if (!text || !activeConvId) return;

            const newMsgRef = push(ref(db, `conversations/${activeConvId}/messages/user_id_${currentUserId}`));
            const msgData = {
                senderId: currentUserId,
                senderName: currentUserName,
                text: text,
                timestamp: Date.now(),
            };

            set(newMsgRef, msgData);
            input.value = "";
        }


        // =================================================
        // 🔹 Start New Conversation
        // =================================================
        sendMessageBtn.addEventListener("click", async () => {
            const messageText = newMessageInput.value.trim();
            const selectedUser = selectUser.value;
            const selectedUserName = selectUser.options[selectUser.selectedIndex]?.text || 'Unknown';

            if (!messageText || !selectedUser) {
                alert("Please select a user and type a message.");
                return;
            }

            const convRef = ref(db, "conversations");
            const snapshot = await get(convRef);
            let existingConvId = null;

            if (snapshot.exists()) {
                const conversations = snapshot.val();
                Object.keys(conversations).forEach((key) => {
                    const conv = conversations[key];
                    if (conv.participants && conv.participants[currentUserId] && conv.participants[
                            selectedUser]) {
                        existingConvId = key;
                    }
                });
            }

            let conversationId = existingConvId;
            if (!conversationId) {
                const newConversationRef = push(convRef);
                conversationId = newConversationRef.key;
                await set(newConversationRef, {
                    participants: {
                        sender_id: currentUserId,
                        reciever_id: selectedUser,
                        reciever_name: selectedUserName
                    },
                    createdAt: Date.now()
                });
            }

            const messagesRef = ref(db, `conversations/${conversationId}/messages/user_id_${currentUserId}`);
            const newMsgRef = push(messagesRef);
            await set(newMsgRef, {
                text: messageText,
                timestamp: Date.now(),
                senderId: currentUserId,
                senderName: currentUserName
            });

            newMessageInput.value = "";
            selectUser.value = "";
        });
    </script>
@endpush
