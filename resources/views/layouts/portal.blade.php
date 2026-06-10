<!DOCTYPE html>
<html lang="en" data-theme="{{ $themeMode ?? 'light' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Businzo RCMS') | {{ $activeOrg->name ?? 'Community Portal' }}</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    @php
        $faviconUrl = $theme->favicon ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png';
        $finalFaviconSrc = (str_starts_with($faviconUrl, 'http') || str_starts_with($faviconUrl, '/'))
            ? $faviconUrl
            : asset('storage/' . $faviconUrl);
    @endphp
    <link rel="shortcut icon" href="{{ $finalFaviconSrc }}">
    <link rel="manifest" href="/manifest.json">
    @include('partials.theme-variables')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body
    style="background-color: var(--background-secondary); color: var(--text-primary); font-family: var(--font-primary, 'Outfit', 'Inter', sans-serif); -webkit-font-smoothing: antialiased; margin: 0; padding: 0; box-sizing: border-box;">
    @include('partials.sidebar')

    <section class="home-section">
        @include('partials.navbar')

        <div class="home-content">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert-custom success"><i class='bx bx-check-circle text-xl'></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-custom error"><i class='bx bx-error-circle text-xl'></i> {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-custom error flex-col items-start">
                    <div class="flex items-center gap-2 mb-2"><i class='bx bx-error-circle text-xl'></i> <strong>Please fix
                            the following errors:</strong></div>
                    <ul class="mb-0 pl-6 list-disc w-full">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </section>

    {{-- Floating Chat --}}
    <a href="javascript:void(0)" class="floating-chat-btn" id="openChatBtn">
        <i class='bx bx-message-rounded-dots'></i>
    </a>

    {{-- Chat Popup Window --}}
    <div class="chat-popup-window" id="chatPopupWindow">
        <div class="chat-popup-header">
            <span><i class='bx bx-support mr-1'></i> Help & Support</span>
            <span class="close-chat-btn" id="closeChatBtn">&times;</span>
        </div>
        <div class="chat-popup-body" id="chatPopupBody">
            <div class="chat-message received">
                Hello! 👋 How can we help you today?
            </div>
        </div>
        <div class="chat-popup-footer">
            <form id="chatPopupForm" onsubmit="handleChatSubmit(event)">
                <input type="text" id="chatInputMessage" placeholder="Type your message..." required autocomplete="off">
                <button type="submit"><i class='bx bx-send'></i></button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        let sidebar = document.querySelector('.sidebar');
        let sidebarBtn = document.querySelector('.sidebarBtn');
        if (sidebarBtn) {
            sidebarBtn.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('active');
                    sidebar.classList.remove('close');
                } else {
                    sidebar.classList.toggle('close');
                    sidebar.classList.remove('active');
                }
            });
        }

        // Chat Widget Toggle
        const chatPopupWindow = document.getElementById('chatPopupWindow');
        const openChatBtn = document.getElementById('openChatBtn');
        const closeChatBtn = document.getElementById('closeChatBtn');
        const chatPopupBody = document.getElementById('chatPopupBody');
        const chatInputMessage = document.getElementById('chatInputMessage');

        if (openChatBtn && chatPopupWindow && closeChatBtn) {
            openChatBtn.addEventListener('click', () => {
                chatPopupWindow.classList.add('active');
                setTimeout(() => chatInputMessage.focus(), 100);
            });

            closeChatBtn.addEventListener('click', () => {
                chatPopupWindow.classList.remove('active');
            });
        }

        // Handle Chat Submission (UI only for now)
        function handleChatSubmit(e) {
            e.preventDefault();
            const message = chatInputMessage.value.trim();
            if (!message) return;

            // Add user message
            const msgHtml = `<div class="chat-message sent">${escapeHtml(message)}</div>`;
            chatPopupBody.insertAdjacentHTML('beforeend', msgHtml);
            chatInputMessage.value = '';
            scrollToBottom();

            // Simulate delayed response
            setTimeout(() => {
                const replyHtml = `<div class="chat-message received">Our team will get back to you shortly. You can also create a detailed Helpdesk ticket.</div>`;
                chatPopupBody.insertAdjacentHTML('beforeend', replyHtml);
                scrollToBottom();
            }, 1000);
        }

        function scrollToBottom() {
            chatPopupBody.scrollTop = chatPopupBody.scrollHeight;
        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            var $tables = $('.data-table:not(.ajax-table), table.w-full.text-left.border-collapse:not(.ajax-table)');
            if ($tables.length > 0) {
                $tables.DataTable({
                    lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
                    pageLength: 10,
                    language: {
                        search: "",
                        searchPlaceholder: "Search records..."
                    },
                    columnDefs: [
                        { targets: 'no-sort', orderable: false }
                    ],
                    retrieve: true
                });
            }
        });
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6a28fd25135ef41c3064c772/1jqo1pni0';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    @stack('scripts')
</body>

</html>