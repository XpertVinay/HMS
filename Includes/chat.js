document.addEventListener('DOMContentLoaded', function() {
    const chatBtn = document.getElementById('chatBtn');
    const chatPanel = document.getElementById('chatPanel');
    const chatClose = document.getElementById('chatClose');
    const chatContacts = document.getElementById('chatContacts');
    const chatConversation = document.getElementById('chatConversation');
    const chatMessages = document.getElementById('chatMessages');
    const chatBack = document.getElementById('chatBack');
    const chatTitle = document.getElementById('chatTitle');
    const chatInput = document.getElementById('chatInput');
    const chatSendBtn = document.getElementById('chatSendBtn');

    let activeTargetId = null;
    let activeTargetType = null;
    let pollTimeout = null;
    let isPolling = false;

    if (!chatBtn) return; // If chat widget not present

    // Toggle chat panel
    chatBtn.addEventListener('click', () => {
        chatPanel.classList.toggle('active');
        if (chatPanel.classList.contains('active')) {
            loadContacts();
        } else {
            stopPolling();
        }
    });

    chatClose.addEventListener('click', () => {
        chatPanel.classList.remove('active');
        stopPolling();
    });

    chatBack.addEventListener('click', () => {
        chatConversation.classList.remove('active');
        chatContacts.style.display = 'block';
        chatBack.style.display = 'none';
        chatTitle.innerText = 'Messages';
        activeTargetId = null;
        activeTargetType = null;
        stopPolling();
    });

    function loadContacts() {
        chatContacts.innerHTML = '<div style="padding:15px; text-align:center;">Loading...</div>';
        const formData = new FormData();
        formData.append('action', 'get_contacts');

        fetch('/Includes/chat_api.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                chatContacts.innerHTML = `<div style="padding:15px; color:red;">${data.error}</div>`;
                return;
            }
            chatContacts.innerHTML = '';
            data.contacts.forEach(contact => {
                const item = document.createElement('div');
                item.className = 'chat-contact-item';
                item.innerHTML = `
                    <div class="chat-contact-icon">${contact.name.charAt(0)}</div>
                    <div style="flex:1;">
                        <div style="font-weight:600; color:#111827;">${contact.name}</div>
                    </div>
                `;
                item.addEventListener('click', () => openConversation(contact.id, contact.type, contact.name));
                chatContacts.appendChild(item);
            });
        })
        .catch(err => {
            chatContacts.innerHTML = '<div style="padding:15px; color:red;">Failed to load contacts.</div>';
        });
    }

    function openConversation(id, type, name) {
        activeTargetId = id;
        activeTargetType = type;
        
        chatContacts.style.display = 'none';
        chatConversation.classList.add('active');
        chatBack.style.display = 'block';
        chatTitle.innerText = name;
        
        chatMessages.innerHTML = '<div style="text-align:center; color:#9ca3af; margin-top:20px;">Loading...</div>';
        
        loadMessages();
        startPolling();
    }

    function loadMessages() {
        if (!activeTargetId) return Promise.resolve();

        const formData = new FormData();
        formData.append('action', 'get_messages');
        formData.append('target_id', activeTargetId);
        formData.append('target_type', activeTargetType);

        return fetch('/Includes/chat_api.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) return;
            
            // Check if user is scrolling up
            const isScrolledToBottom = chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages.scrollTop + 50;
            
            // Avoid complete wipe if possible, but for simplicity, we wipe and redraw.
            chatMessages.innerHTML = '';
            
            if (data.messages.length === 0) {
                chatMessages.innerHTML = '<div style="text-align:center; color:#9ca3af; margin-top:20px;">Say hello!</div>';
            }

            data.messages.forEach(msg => {
                const isSentByMe = (msg.sender_id == data.my_id && msg.sender_type == data.my_role);
                const bubble = document.createElement('div');
                bubble.className = `chat-bubble ${isSentByMe ? 'sent' : 'received'}`;
                bubble.innerText = msg.message;
                
                // Add timestamp (very basic)
                const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                const timeSpan = document.createElement('div');
                timeSpan.style.fontSize = '10px';
                timeSpan.style.marginTop = '4px';
                timeSpan.style.opacity = '0.7';
                timeSpan.style.textAlign = isSentByMe ? 'right' : 'left';
                timeSpan.innerText = time;
                bubble.appendChild(timeSpan);
                
                chatMessages.appendChild(bubble);
            });

            if (isScrolledToBottom || data.messages.length === 0) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    }

    function pollMessages() {
        if (!isPolling) return;
        loadMessages().then(() => {
            if (isPolling) {
                pollTimeout = setTimeout(pollMessages, 4000); // Poll every 4 seconds
            }
        }).catch(() => {
            if (isPolling) {
                pollTimeout = setTimeout(pollMessages, 5000); // On error wait 5s
            }
        });
    }

    function startPolling() {
        stopPolling();
        isPolling = true;
        pollMessages();
    }

    function stopPolling() {
        isPolling = false;
        if (pollTimeout) {
            clearTimeout(pollTimeout);
            pollTimeout = null;
        }
    }

    function sendMessage() {
        const text = chatInput.value.trim();
        if (!text || !activeTargetId) return;

        chatInput.value = ''; // clear immediately
        
        const formData = new FormData();
        formData.append('action', 'send_message');
        formData.append('target_id', activeTargetId);
        formData.append('target_type', activeTargetType);
        formData.append('message', text);

        // Optimistic UI update
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble sent';
        bubble.innerText = text;
        bubble.style.opacity = '0.7';
        chatMessages.appendChild(bubble);
        chatMessages.scrollTop = chatMessages.scrollHeight;

        fetch('/Includes/chat_api.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Immediately fetch authoritative state without waiting for next poll
                loadMessages();
            } else {
                bubble.style.color = 'red';
                bubble.innerText += ' (Failed)';
            }
        });
    }

    chatSendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
});
