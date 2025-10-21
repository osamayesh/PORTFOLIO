// Article AI Chat functionality
const ArticleAIChat = {
    chatWindow: null,
    chatMessages: null,
    chatInput: null,
    sendButton: null,
    isProcessing: false,
    articleId: null,
    articleContent: '',

    init() {
        this.chatWindow = document.getElementById('ai-chat-window');
        this.chatMessages = document.getElementById('chat-messages');
        this.chatInput = document.getElementById('chat-input');
        this.sendButton = document.getElementById('send-message');
        
        // Get article ID from meta tag
        const metaArticleId = document.querySelector('meta[name="article-id"]');
        this.articleId = metaArticleId ? metaArticleId.content : null;
        
        // Get CSRF token
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!this.articleId) {
            console.error('Article ID not found');
            return;
        }
        
        // Extract article content
        this.extractArticleContent();
        
        // Event listeners
        document.getElementById('ai-chat-toggle')?.addEventListener('click', () => this.toggleChat());
        document.getElementById('close-chat')?.addEventListener('click', () => this.toggleChat());
        this.sendButton?.addEventListener('click', () => this.sendMessage());
        
        this.chatInput?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Quick action buttons
        document.querySelectorAll('.quick-action-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const action = e.target.closest('button').dataset.action;
                this.handleQuickAction(action);
            });
        });
    },

    extractArticleContent() {
        const title = document.querySelector('h1')?.textContent || '';
        const description = document.querySelector('.description-container p')?.textContent || '';
        const articleContainer = document.querySelector('.article-content');
        const content = articleContainer?.textContent.trim() || '';
        
        this.articleContent = `
عنوان المقال: ${title}

الوصف: ${description}

المحتوى:
${content.substring(0, 8000)}
        `.trim();
    },

    toggleChat() {
        this.chatWindow?.classList.toggle('hidden');
        if (!this.chatWindow?.classList.contains('hidden')) {
            this.chatInput?.focus();
        }
    },

    async sendMessage() {
        const message = this.chatInput?.value.trim();
        if (!message || this.isProcessing) return;

        this.addMessage(message, 'user');
        this.chatInput.value = '';
        
        await this.processWithAI(message);
    },

    async handleQuickAction(action) {
        if (this.isProcessing) return;

        const locale = document.documentElement.lang || 'ar';
        let prompt = '';

        switch(action) {
            case 'summarize':
                prompt = locale === 'ar' 
                    ? 'لخص لي هذا المقال في 3-5 نقاط رئيسية' 
                    : 'Summarize this article in 3-5 key points';
                break;
            case 'key-points':
                prompt = locale === 'ar'
                    ? 'ما هي النقاط الرئيسية والمفاهيم المهمة في هذا المقال؟'
                    : 'What are the main points and important concepts in this article?';
                break;
            case 'explain':
                prompt = locale === 'ar'
                    ? 'اشرح لي هذا المقال بطريقة مبسطة وسهلة الفهم'
                    : 'Explain this article in a simple and easy-to-understand way';
                break;
        }

        this.addMessage(prompt, 'user');
        await this.processWithAI(prompt);
    },

    async processWithAI(userMessage) {
        this.isProcessing = true;
        this.setButtonState(true);
        
        const locale = document.documentElement.lang || 'ar';
        const loadingId = this.addMessage(
            locale === 'ar' ? 'جاري التفكير...' : 'Thinking...', 
            'ai', 
            true
        );

        try {
            const response = await fetch('/api/chat/article', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    article_id: this.articleId,
                    message: userMessage,
                    article_content: this.articleContent
                })
            });

            const data = await response.json();
            
            this.removeMessage(loadingId);

            if (data.success && data.response) {
                this.addMessage(data.response, 'ai');
            } else {
                throw new Error(data.error || 'Failed to get response');
            }

        } catch (error) {
            console.error('AI Error:', error);
            this.removeMessage(loadingId);
            this.addMessage(
                locale === 'ar' 
                    ? 'عذراً، حدث خطأ. الرجاء المحاولة مرة أخرى.' 
                    : 'Sorry, an error occurred. Please try again.',
                'ai'
            );
        } finally {
            this.isProcessing = false;
            this.setButtonState(false);
        }
    },

    setButtonState(disabled) {
        if (this.sendButton) {
            this.sendButton.disabled = disabled;
        }
        if (this.chatInput) {
            this.chatInput.disabled = disabled;
        }
    },

    addMessage(text, sender, isLoading = false) {
        const messageId = `msg-${Date.now()}`;
        const messageDiv = document.createElement('div');
        messageDiv.id = messageId;
        messageDiv.className = 'flex items-start gap-2 animate-fadeIn';
        
        const locale = document.documentElement.lang || 'ar';
        const direction = locale === 'ar' ? 'rtl' : 'ltr';
        
        if (sender === 'ai') {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center flex-shrink-0">
                    <span class="text-white text-xs font-bold">AI</span>
                </div>
                <div class="bg-gray-800 rounded-lg p-3 max-w-[80%]">
                    <p class="text-gray-300 text-sm ${direction} ${isLoading ? 'animate-pulse' : ''}">
                        ${this.formatMessage(text)}
                    </p>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="flex-1"></div>
                <div class="bg-blue-600 rounded-lg p-3 max-w-[80%]">
                    <p class="text-white text-sm ${direction}">
                        ${this.escapeHtml(text)}
                    </p>
                </div>
                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            `;
        }

        this.chatMessages?.appendChild(messageDiv);
        this.chatMessages.scrollTop = this.chatMessages.scrollHeight;

        return messageId;
    },

    removeMessage(messageId) {
        const message = document.getElementById(messageId);
        if (message) message.remove();
    },

    formatMessage(text) {
        return this.escapeHtml(text)
            .replace(/\*\*(.*?)\*\*/g, '<strong class="text-blue-300">$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code class="bg-gray-900 px-1 py-0.5 rounded text-blue-400">$1</code>')
            .replace(/\n\n/g, '</p><p class="mt-2">')
            .replace(/\n/g, '<br>');
    },

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => ArticleAIChat.init());
} else {
    ArticleAIChat.init();
}

