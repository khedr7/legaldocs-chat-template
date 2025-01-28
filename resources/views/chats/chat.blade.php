@extends('layouts.app')

@section('content')
	<div class="container-fluid p-0 h-100 d-flex flex-column">
		<div class="row g-0 h-100">
			<!-- Sidebar Toggle Button (for mobile) -->
			<button class="btn btn-link text-light p-0 ms-2 d-md-none" id="sidebarToggle" style="z-index: 1050;">
				<i class="fas fa-bars fs-4"></i>
			</button>

			<!-- Sidebar -->
			<div class="col-md-2 col-3 bg-black p-3 vh-100 d-flex flex-column" id="sidebar"
				style="border-right: 1px solid #444; transition: width 0.5s;">
				<form action="{{ route('logout') }}" method="POST">
					@csrf
					<div class="d-flex justify-content-between align-items-center mb-3">
						<h5 class="mb-0 text-white">History</h5>
						<div class="d-flex align-items-center gap-2">
							<a href="{{ route('chat.index') }}" class="btn btn-link text-light p-0" title="New Chat">
								<i class="fas fa-plus-circle fs-4"></i>
							</a>
							<button type="submit" class="btn btn-link text-light p-0">
								<i class="fas fa-sign-out-alt fs-4"></i>
							</button>
						</div>
					</div>
				</form>

				<!-- Chat List -->
				<ul class="list-group flex-grow-1 overflow-auto">
					@foreach ($chats as $ch)
						<a href="{{ route('chat.details', $ch->id) }}" class="text-light text-decoration-none">
							<li
								class="list-group-item border-0 p-3 mb-2 bg-dark text-light rounded d-flex align-items-center justify-content-between"
								style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); height: 60px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
								<small class="text-truncate" style="max-width: calc(100% - 30px);">{{ $ch->title }}</small>
							</li>
						</a>
					@endforeach
				</ul>
			</div>

			<!-- Main Chat Area -->
			<div class="col-md-10 col-9 d-flex flex-column vh-100" id="mainChatArea">
				<div class="bg-secondary text-white p-3 d-flex justify-content-between align-items-center">
					<h5 class="m-0">Legal docs Chatbot</h5>
				</div>

				<!-- Chat Messages Area -->
				<div class="chat-area p-4 overflow-auto flex-grow-1" id="chat-history" style="background-color: #212121;">
					@if (isset($chat))
						@foreach ($chat->messages as $message)
							@if ($message->message)
								<div class="message user-message mb-3 p-3 rounded ms-auto"
									style="background-color: #555; color: white; max-width: 60%; width: fit-content;
                                    word-wrap: break-word; white-space: normal; border-radius: 15px!important;"
									dir="{{ preg_match('/\p{Arabic}/u', $message->message) ? 'rtl' : 'ltr' }}">
									{{ $message->message }}
								</div>
							@endif

							@if ($message->response)
								<div class="message bot-message" style="max-width: 100%; word-wrap: break-word; white-space: normal;"
									dir="{{ preg_match('/\p{Arabic}/u', $message->response) ? 'rtl' : 'ltr' }}">
									{!! \Parsedown::instance()->text($message->response) !!}
								</div>
							@endif
						@endforeach
					@endif
				</div>


				<!-- Message Input Area -->
				<div class="input-area p-3" style="background-color: #212121;">
					<form id="chat-form" class="d-flex align-items-center" method="POST">
						@csrf
						<textarea class="form-control me-2 bg-secondary text-light border-0" name="message" id="message"
						 placeholder="Type your message" rows="2" style="border-radius: 15px; background-color: #444 !important;"
						 required></textarea>
						<button class="btn btn-link text-white p-0 ms-2" type="button" onclick="sendMessage(this)"
							style="color: white; width: 40px; height: 40px; border-radius: 50%; justify-content: center; align-items: center; background-color: #444; border: none;">
							<i class="fas fa-arrow-up fs-4"></i>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
	integrity="sha384-UG8ao2jwOWB7/oDdObZc6ItJmwUkR/PfMyt9Qs5AwX7PsnYn1CRKCTWyncPTWvaS" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/showdown/dist/showdown.min.js"></script>

<script>
	// Declare the conversationId outside the sendMessage function
	let conversationId = {{ $conversation_id ?? 'null' }};

	// Sidebar toggle functionality for both opening and closing
	document.addEventListener('DOMContentLoaded', function() {
		const sidebarToggle = document.getElementById('sidebarToggle');
		const sidebar = document.getElementById('sidebar');
		const mainChatArea = document.getElementById('mainChatArea');

		// Ensure sidebar toggle is available and apply event listener
		if (sidebarToggle && sidebar) {
			sidebarToggle.addEventListener('click', function() {
				const isClosed = sidebar.style.width === "0px";
				if (isClosed) {
					sidebar.style.width = "300px";
					mainChatArea.style.marginLeft = "300px"; // Adjust chat area when sidebar opens
				} else {
					sidebar.style.width = "0";
					mainChatArea.style.marginLeft =
						"0"; // Expand chat area to full width when sidebar closes
				}
			});
		}
	});

	function sendMessage(button) {
		const messageInput = document.getElementById('message');
		const message = messageInput.value.trim();
		const chatArea = document.getElementById('chat-history');

		if (!message) {
			return;
		}

		const userMessage = document.createElement('div');
		userMessage.classList.add('message', 'user-message', 'mb-3', 'p-3', 'rounded', 'ms-auto');
		userMessage.style.backgroundColor = '#555';
		userMessage.style.color = 'white';
		userMessage.style.maxWidth = '60%';
		userMessage.style.width = 'fit-content';
		userMessage.style.wordWrap = 'break-word';
		userMessage.style.whiteSpace = 'normal';
		userMessage.innerHTML = message;
		chatArea.appendChild(userMessage);

		chatArea.scrollTop = chatArea.scrollHeight;

		messageInput.value = '';

		$.ajax({
			type: "POST",
			url: '{{ route('chat.send') }}',
			data: {
				message: message,
				conversation_id: conversationId,
				_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			},
			success: function(data) {
				if (conversationId === null) {
					conversationId = data.conversation_id;
					console.log("Updated conversationId: ", conversationId);
				}

				const botMessage = document.createElement('div');

				// botMessage.classList.add('message', 'bot-message', 'mb-3', 'p-3', 'rounded', 'text-light');
				botMessage.classList.add('message', 'bot-message');

				// botMessage.style.borderRadius = '15px';
				// botMessage.style.color = 'white';
				// botMessage.style.maxWidth = '100%';
				// botMessage.style.width = 'fit-content';
				// botMessage.style.wordWrap = 'break-word';
				// botMessage.style.whiteSpace = 'normal';

				// Check if the response contains Arabic characters
				const isArabic = /[\u0600-\u06FF]/.test(data.response);
				botMessage.setAttribute('dir', isArabic ? 'rtl' : 'ltr');

				// Convert Markdown to HTML (if needed)
				const parsedResponse = new showdown.Converter().makeHtml(data
					.response); // Use Showdown.js or a similar library for Markdown
				botMessage.innerHTML = `<span style="white-space: pre-line;">${parsedResponse}</span>`;
				// botMessage.innerHTML = `<span style="white-space: pre-line;">${data.response}</span>`;

				// Append the bot message to the chat area
				chatArea.appendChild(botMessage);


				chatArea.scrollTop = chatArea.scrollHeight;
			},
			error: function(xhr, status, error) {
				console.error('Error sending message:', error);
				const errorMessage = document.createElement('div');
				errorMessage.classList.add('message', 'error-message', 'mb-3', 'p-3', 'rounded',
					'text-danger');
				errorMessage.innerHTML =
					`<span style="white-space: pre-line;">Error: Unable to send the message. Please try again.</span>`;
				chatArea.appendChild(errorMessage);

				chatArea.scrollTop = chatArea.scrollHeight;
			}
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		const chatArea = document.getElementById('chat-history');
		if (chatArea) {
			// Scroll to the bottom
			chatArea.scrollTop = chatArea.scrollHeight;
		}
	});
</script>
