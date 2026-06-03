<?php if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); } ?>
    </div>
</section>

<!-- Chat Widget (Only for logged in portal users) -->
<link rel="stylesheet" href="/Includes/chat.css">
<div class="chat-widget">
    <div class="chat-panel" id="chatPanel">
        <div class="chat-header">
            <div style="display:flex; align-items:center;">
                <i class='bx bx-arrow-back chat-back' id="chatBack"></i>
                <span id="chatTitle">Messages</span>
            </div>
            <i class='bx bx-x chat-close' id="chatClose"></i>
        </div>
        <div class="chat-body">
            <!-- Contacts View -->
            <div class="chat-contacts" id="chatContacts">
                <!-- Loaded via JS -->
            </div>
            
            <!-- Conversation View -->
            <div class="chat-conversation" id="chatConversation">
                <div class="chat-messages" id="chatMessages">
                    <!-- Messages go here -->
                </div>
                <div class="chat-input-area">
                    <input type="text" id="chatInput" placeholder="Type a message...">
                    <button id="chatSendBtn"><i class='bx bx-send'></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-button" id="chatBtn">
        <i class='bx bx-message-rounded-dots'></i>
    </div>
</div>
<script src="/Includes/chat.js"></script>

<script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    if(sidebarBtn) {
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    }
</script>
</body>
</html>
