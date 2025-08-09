document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('zahra-chat-widget-container');
    if (!container) return;

    let sessionId = `chat_${Date.now()}`;
    let isOpen = false;

    // Inject the HTML for the widget
    container.innerHTML = `
        <div id="zahra-chat-window" class="card shadow-lg animate__animated animate__slideInUp" style="display: none; width: 350px; height: 500px; flex-direction: column;">
            <div class="card-header bg-primary text-white">
                <strong>Chat with Zahra AI</strong>
                <button id="zahra-close-btn" type="button" class="btn-close btn-close-white float-end" aria-label="Close"></button>
            </div>
            <div id="zahra-chat-messages" class="card-body" style="flex-grow: 1; overflow-y: auto;">
                <!-- Messages will be injected here -->
                <div class="d-flex justify-content-start mb-2">
                    <div class="bg-light p-2 rounded">Hi! How can I help you today?</div>
                </div>
            </div>
            <div class="card-footer">
                <form id="zahra-chat-form">
                    <div class="input-group">
                        <input type="text" id="zahra-chat-input" class="form-control" placeholder="Ask something..." autocomplete="off" required>
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
        <button id="zahra-open-btn" class="btn btn-primary btn-lg rounded-circle shadow-lg animate__animated animate__pulse animate__infinite">
            <i class="bi bi-robot"></i>
        </button>
    `;

    const openBtn = document.getElementById('zahra-open-btn');
    const closeBtn = document.getElementById('zahra-close-btn');
    const chatWindow = document.getElementById('zahra-chat-window');
    const chatForm = document.getElementById('zahra-chat-form');
    const chatInput = document.getElementById('zahra-chat-input');
    const messagesContainer = document.getElementById('zahra-chat-messages');

    const toggleChat = () => {
        isOpen = !isOpen;
        chatWindow.style.display = isOpen ? 'flex' : 'none';
        openBtn.style.display = isOpen ? 'none' : 'block';
    };

    openBtn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        chatInput.value = '';
        toggleLoading(true);

        try {
            const response = await fetch('/api/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message, session_id: sessionId }),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            sessionId = data.session_id; // Persist session id
            appendMessage(data.reply, 'ai');

        } catch (error) {
            console.error('AI Chat Error:', error);
            appendMessage('Sorry, I am having trouble connecting. Please try again later.', 'ai');
        } finally {
            toggleLoading(false);
        }
    });

    const appendMessage = (text, sender) => {
        const alignClass = sender === 'user' ? 'justify-content-end' : 'justify-content-start';
        const bgClass = sender === 'user' ? 'bg-primary text-white' : 'bg-light';
        const messageEl = document.createElement('div');
        messageEl.className = `d-flex ${alignClass} mb-2`;
        messageEl.innerHTML = `<div class="${bgClass} p-2 rounded" style="max-width: 80%;">${text}</div>`;
        messagesContainer.appendChild(messageEl);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    };

    const toggleLoading = (isLoading) => {
        const loadingElId = 'zahra-loading-indicator';
        let loadingIndicator = document.getElementById(loadingElId);
        if (isLoading) {
            if (!loadingIndicator) {
                loadingIndicator = document.createElement('div');
                loadingIndicator.id = loadingElId;
                loadingIndicator.className = 'd-flex justify-content-start mb-2';
                loadingIndicator.innerHTML = `<div class="bg-light p-2 rounded">...</div>`;
                messagesContainer.appendChild(loadingIndicator);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        } else {
            if (loadingIndicator) {
                loadingIndicator.remove();
            }
        }
    };
});
