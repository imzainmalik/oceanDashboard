@extends('layouts.app')
@section('content')
 

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<div class="card shadow-sm" id="chatCard" style="height: 600px;">
  <div class="card-header d-flex align-items-center">
    <div class="flex-grow-1">
      <strong id="chatRoomTitle">Family Chat</strong>
      <div class="small text-muted" id="chatSubtitle">Realtime messages</div>
    </div>
    <div class="ms-2">
      <button class="btn btn-sm btn-outline-secondary" id="changeNameBtn">Change name</button>
    </div>
  </div>

  <div class="card-body d-flex flex-column p-2">
    <!-- message list -->
    <div id="messages" class="flex-grow-1 overflow-auto mb-2" style="min-height: 120px;">
      <!-- messages appended here -->
    </div>

    <!-- typing indicator -->
    <div id="typingIndicator" class="small text-muted mb-2" style="height:18px; display:none;">Someone is typing...</div>

    <!-- composer -->
    <div class="input-group">
      <input id="messageInput" type="text" class="form-control" placeholder="Type a message..." autocomplete="off" />
      <button id="sendBtn" class="btn btn-primary">Send</button>
    </div>
  </div>
</div> 
  @endsection

  @push('js')
      
<!-- Firebase + Chat JS -->
<script type="module">
  // Firebase imports (v12)
  import { initializeApp } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-app.js";
  import { getDatabase, ref, push, onChildAdded, serverTimestamp, set, update, onValue, remove } from "https://www.gstatic.com/firebasejs/12.3.0/firebase-database.js";

  // ---------- CONFIG ----------
  const firebaseConfig = {
    apiKey: "AIzaSyBBC2zLE2PeBe0dErhr74EfE1Q07mzWzHs",
    authDomain: "bridgeline-54be0.firebaseapp.com",
    projectId: "bridgeline-54be0",
    storageBucket: "bridgeline-54be0.firebasestorage.app",
    messagingSenderId: "227803086615",
    appId: "1:227803086615:web:308289f10be9063b5b0152",
    measurementId: "G-JRS6Z5FWBZ"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const db = getDatabase(app);

  // ---------- CHAT CONFIG ----------
  // Choose a room id — set dynamically from Laravel if needed
  const roomId = "{{ $roomId ?? 'family_1' }}";
//   const roomId = 'family_room_1'; // change per conversation / senior / family owner
  const roomRef = ref(db, `rooms/${roomId}/messages`);
  const presenceRef = ref(db, `rooms/${roomId}/presence`);
  const typingRef = ref(db, `rooms/${roomId}/typing`);

  // UI elements
  const messagesEl = document.getElementById('messages');
  const inputEl = document.getElementById('messageInput');
  const sendBtn = document.getElementById('sendBtn');
  const typingIndicator = document.getElementById('typingIndicator');
  const changeNameBtn = document.getElementById('changeNameBtn');

  // user identity (local)
  let userId = localStorage.getItem('chat_user_id');
  if (!userId) {
    userId = 'u_' + Math.random().toString(36).slice(2, 10);
    localStorage.setItem('chat_user_id', userId);
  }
  let displayName = '{{ auth()->user()->name }}';
  localStorage.setItem('chat_display_name', displayName);

  // helper: format timestamp
  function fmtTime(ts) {
    if (!ts) return '';
    const d = new Date(ts);
    return d.toLocaleString(); // adjust format as needed
  }

  // helper: add message to DOM
  function addMessageToDOM(msg) {
    // msg: { id, senderId, senderName, text, timestamp }
    const wrapper = document.createElement('div');
    wrapper.className = 'd-flex mb-2';
    const isMe = msg.senderId === userId;
    if (isMe) wrapper.classList.add('justify-content-end');

    const bubble = document.createElement('div');
    bubble.className = 'p-2 rounded shadow-sm';
    bubble.style.maxWidth = '75%';
    bubble.style.wordBreak = 'break-word';
    bubble.style.background = isMe ? '#0d6efd' : '#f1f3f5';
    bubble.style.color = isMe ? 'white' : '#212529';

    let nameLine = document.createElement('div');
    nameLine.className = 'small text-muted mb-1';
    nameLine.textContent = (isMe ? 'You' : msg.senderName) + ' · ' + fmtTime(msg.timestamp);
    if (isMe) nameLine.style.textAlign = 'right';

    const textLine = document.createElement('div');
    textLine.textContent = msg.text;

    bubble.appendChild(nameLine);
    bubble.appendChild(textLine);
    wrapper.appendChild(bubble);
    messagesEl.appendChild(wrapper);

    // scroll to bottom
    messagesEl.scrollTop = messagesEl.scrollHeight;
  }

  // ---------- LISTEN: new messages ----------
  onChildAdded(roomRef, (snap) => {
    const data = snap.val();
    if (!data) return;
    const msg = {
      id: snap.key,
      senderId: data.senderId,
      senderName: data.senderName,
      text: data.text,
      timestamp: data.timestamp
    };
    addMessageToDOM(msg);
  });

  // ---------- TYPING INDICATOR ----------
  let typingTimeout;
  inputEl.addEventListener('input', () => {
    // set typing true for current user
    set(ref(db, `rooms/${roomId}/typing/${userId}`), {
      name: displayName,
      ts: Date.now()
    });

    // remove typing after 2.5s of inactivity
    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(() => {
      remove(ref(db, `rooms/${roomId}/typing/${userId}`));
    }, 2500);
  });

  // show/hide typing indicator when any other user is typing
  onValue(typingRef, (snap) => {
    const items = snap.val() || {};
    // remove own entry (we don't show "You are typing")
    const others = Object.keys(items).filter(k => k !== userId);
    if (others.length > 0) {
      typingIndicator.style.display = 'block';
      const names = others.map(k => items[k]?.name || 'Someone').slice(0,3);
      typingIndicator.textContent = names.join(', ') + (others.length > names.length ? ' and more...' : '') + ' is typing...';
    } else {
      typingIndicator.style.display = 'none';
    }
  });

  // ---------- PRESENCE (optional simple) ----------
  // mark online
  set(ref(db, `rooms/${roomId}/presence/${userId}`), {
    name: displayName,
    lastSeen: Date.now(),
  });
  // remove presence on unload
  window.addEventListener('beforeunload', () => {
    remove(ref(db, `rooms/${roomId}/presence/${userId}`));
  });

  // ---------- SEND MESSAGE ----------
  async function sendMessage() {
    const text = inputEl.value.trim();
    if (!text) return;
    sendBtn.disabled = true;

    // push message to firebase
    const newRef = push(roomRef);
    await set(newRef, {
      senderId: userId,
      senderName: displayName,
      text: text,
      timestamp: Date.now(),
    });

    // clear input and remove typing entry
    inputEl.value = '';
    remove(ref(db, `rooms/${roomId}/typing/${userId}`));
    sendBtn.disabled = false;
    inputEl.focus();
  }

  sendBtn.addEventListener('click', sendMessage);
  inputEl.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  // change display name
  changeNameBtn.addEventListener('click', () => {
    const newName = prompt('Enter display name', displayName);
    if (newName && newName.trim()) {
      displayName = newName.trim();
      localStorage.setItem('chat_display_name', displayName);
      // update presence node
      set(ref(db, `rooms/${roomId}/presence/${userId}`), {
        name: displayName,
        lastSeen: Date.now()
      });
    }
  });

  // ---------- OPTIONAL: load last N messages initially ----------
  // OnChildAdded will stream new messages — if you want to show last N you need a query.
  // For simple usage, consider using a server side rule to limit writes, or read entire node for low-volume chat.

  // ---------- SECURITY NOTE ----------
  // This demo writes directly to your Realtime Database. For production you MUST:
  // 1) Protect your database with proper Realtime Database Rules so only authenticated users can read/write:
  //    {
  //      "rules": {
  //        "rooms": {
  //          "$roomId": {
  //            ".read": "auth != null", 
  //            ".write": "auth != null"
  //          }
  //        }
  //      }
  //    }
  // 2) Use Firebase Authentication (or your server to mint custom tokens) instead of anonymous localStorage ids.
  // 3) Validate and sanitize message content server-side (Cloud Functions or security rules) as needed.
  //
  // If you want, I can provide secure rules and instructions to sign users in using your Laravel auth (custom tokens).

  console.log('Realtime chat initialized as', displayName, userId);
  </script>
  @endpush