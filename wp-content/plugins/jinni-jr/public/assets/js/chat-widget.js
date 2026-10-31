/* Jinni Jr Chat Widget JavaScript */

(function() {
    'use strict';

    var config = window.jinniJrConfig || {};
    var restUrl = config.restUrl || '';
    var nonce = config.nonce || '';

    var robotBtn = document.querySelector('.jinni-jr-robot');
    var chatWindow = document.getElementById('jinni-jr-chat');
    var chatClose = document.querySelector('.jinni-jr-chat-close');
    var chatForm = document.getElementById('jinni-jr-chat-form');
    var chatInput = document.getElementById('jinni-jr-chat-input');
    var chatSend = document.getElementById('jinni-jr-chat-send');
    var messagesContainer = document.getElementById('jinni-jr-chat-messages');
    var typingIndicator = document.getElementById('jinni-jr-chat-typing');
    var errorEl = document.getElementById('jinni-jr-chat-error');
    var hiBubble = document.getElementById('jinni-jr-robot-hi');

    var conversationId = null;
    var visitorToken = getOrCreateVisitorToken();

    // Show "Hi" bubble after a few seconds
    setTimeout(function() {
        if (hiBubble && chatWindow && chatWindow.hidden) {
            hiBubble.classList.add('show');
            hiBubble.setAttribute('aria-hidden', 'false');
        }
    }, 3000);

    function getOrCreateVisitorToken() {
        var token = localStorage.getItem('jinni_jr_visitor_token');
        if (!token) {
            token = 'v_' + Math.random().toString(36).substr(2, 16) + '_' + Date.now();
            try {
                localStorage.setItem('jinni_jr_visitor_token', token);
            } catch (e) {
                // localStorage unavailable; use session-only
            }
        }
        return token;
    }

    function openChat() {
        if (chatWindow) {
            chatWindow.removeAttribute('hidden');
            chatWindow.setAttribute('aria-hidden', 'false');
            robotBtn.setAttribute('aria-expanded', 'true');
            if (hiBubble) {
                hiBubble.classList.remove('show');
                hiBubble.setAttribute('aria-hidden', 'true');
            }
            if (chatInput) {
                chatInput.focus();
            }
        }
    }

    function closeChat() {
        if (chatWindow) {
            chatWindow.setAttribute('hidden', '');
            chatWindow.setAttribute('aria-hidden', 'true');
            robotBtn.setAttribute('aria-expanded', 'false');
        }
    }

    function appendMessage(text, role) {
        if (!messagesContainer || !text) return;
        var div = document.createElement('div');
        div.className = 'jinni-jr-message jinni-jr-message-' + (role === 'user' ? 'user' : 'bot');
        div.textContent = text;
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function showTyping(show) {
        if (!typingIndicator) return;
        typingIndicator.hidden = !show;
        if (show) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    function showError(msg) {
        if (!errorEl) return;
        errorEl.textContent = msg;
        errorEl.hidden = false;
        setTimeout(function() {
            errorEl.hidden = true;
        }, 5000);
    }

    function clearError() {
        if (!errorEl) return;
        errorEl.hidden = true;
    }

    function setSending(sending) {
        if (!chatSend || !chatInput) return;
        chatSend.disabled = sending;
        chatInput.disabled = sending;
        chatSend.setAttribute('aria-label', sending ? 'Sending message' : 'Send message');
    }

    async function sendMessage(text) {
        if (!text || !text.trim()) return;
        clearError();
        appendMessage(text, 'user');
        chatInput.value = '';
        showTyping(true);
        setSending(true);

        try {
            var response = await fetch(restUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': nonce
                },
                body: JSON.stringify({
                    visitor_token: visitorToken,
                    conversation_id: conversationId,
                    message: text.trim()
                })
            });

            var data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Failed to send message.');
            }

            if (data.conversation_id && !conversationId) {
                conversationId = data.conversation_id;
            }

            showTyping(false);

            if (data.reply) {
                appendMessage(data.reply, 'bot');
            } else {
                appendMessage('Sorry, I did not get a response. Please try again.', 'bot');
            }
        } catch (err) {
            showTyping(false);
            showError(err.message || 'Network error. Please try again.');
        } finally {
            setSending(false);
        }
    }

    if (robotBtn) {
        robotBtn.addEventListener('click', function() {
            if (chatWindow && !chatWindow.hidden) {
                closeChat();
            } else {
                openChat();
            }
        });

        robotBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (chatWindow && !chatWindow.hidden) {
                    closeChat();
                } else {
                    openChat();
                }
            }
        });
    }

    if (chatClose) {
        chatClose.addEventListener('click', closeChat);
    }

    if (chatForm) {
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey && !e.isComposing) {
                e.preventDefault();
                if (!chatSend.disabled) chatForm.requestSubmit();
            }
        });
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var text = chatInput ? chatInput.value : '';
            sendMessage(text);
        });
    }

})();
