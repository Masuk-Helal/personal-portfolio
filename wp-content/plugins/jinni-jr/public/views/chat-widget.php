<div id="jinni-jr-widget" class="jinni-jr-widget" aria-label="Chat with Jinni Jr">
    <div class="jinni-jr-robot" role="button" tabindex="0" aria-expanded="false" aria-controls="jinni-jr-chat" aria-label="Open chat" title="Open chat">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M20 11.5a8 8 0 0 1-8 8 8.4 8.4 0 0 1-3.5-.8L4 20l1.3-4.2A8 8 0 1 1 20 11.5Z"/><path d="M8.5 11.5h7M12 8v7" stroke-linecap="round"/></svg>
        <div class="robot-tooltip">Chat with Jinni Jr</div>
        <div class="robot-hi-bubble" id="jinni-jr-robot-hi" aria-hidden="true">Hi!</div>
    </div>

    <div id="jinni-jr-chat" class="jinni-jr-chat" role="dialog" aria-labelledby="jinni-jr-chat-title" hidden>
        <div class="jinni-jr-chat-window">
            <div class="jinni-jr-chat-header">
                <div><h3 id="jinni-jr-chat-title">Jinni Jr</h3><span class="jinni-jr-chat-subtitle">Your AI assistant</span></div>
                <button type="button" class="jinni-jr-chat-close" aria-label="Close chat">&times;</button>
            </div>
            <div class="jinni-jr-chat-messages" id="jinni-jr-chat-messages" role="log" aria-live="polite">
                <div class="jinni-jr-message jinni-jr-message-bot">
                    Hello! I'm Jinni Jr. How can I help you today?
                </div>
            </div>
            <div class="jinni-jr-chat-typing" id="jinni-jr-chat-typing" hidden>
                <span class="dot"></span><span class="dot"></span><span class="dot"></span>
            </div>
            <div class="jinni-jr-chat-input-area">
                <form id="jinni-jr-chat-form" aria-label="Send a message">
                    <textarea id="jinni-jr-chat-input" rows="2" placeholder="Ask me anything..." aria-label="Message"></textarea>
                    <div class="jinni-jr-composer-footer"><span>Jinni Jr</span><button type="submit" id="jinni-jr-chat-send" aria-label="Send message"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 19V5m-6 6 6-6 6 6" stroke-linecap="round" stroke-linejoin="round"/></svg></button></div>
                </form>
                <div id="jinni-jr-chat-error" class="jinni-jr-chat-error" role="alert" hidden></div>
            </div>
        </div>
    </div>
</div>
