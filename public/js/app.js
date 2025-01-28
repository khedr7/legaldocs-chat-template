// resources/js/app.js

import './bootstrap';

// Send message functionality
const chatForm = document.getElementById('chat-form');
const messageInput = document.getElementById('message');
const chatHistory = document.getElementById('chat-history');

// Listen for form submit and send message
chatForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const message = messageInput.value.trim();
    if (message) {
        // Example: You can send an AJAX request to send the message to the server
        axios.post('/send-message', { message })
            .then(response => {
                if (response.data.success) {
                    // Append the new message to the chat history
                    const userMessage = document.createElement('div');
                    userMessage.classList.add('message', 'user-message');
                    userMessage.textContent = 'You: ' + message;
                    chatHistory.appendChild(userMessage);
                    messageInput.value = ''; // Clear the input
                    chatHistory.scrollTop = chatHistory.scrollHeight; // Scroll to the bottom
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
            });
    }
});

// Example: Handling incoming messages from the bot (this could be set up via WebSockets or polling)
function addBotMessage(message) {
    const botMessage = document.createElement('div');
    botMessage.classList.add('message', 'bot-message');
    botMessage.textContent = 'Bot: ' + message;
    chatHistory.appendChild(botMessage);
    chatHistory.scrollTop = chatHistory.scrollHeight; // Scroll to the bottom
}

// Example for adding bot responses
setTimeout(() => {
    addBotMessage("Hello, how can I assist you today?");
}, 2000); // Simulate a bot response after 2 seconds
