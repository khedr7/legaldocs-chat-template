@extends('layouts.app')

@section('content')
	<div class="container-fluid p-0 h-100 d-flex flex-column">
		<div class="row g-0 h-100">
			<!-- Sidebar Toggle Button (for mobile) -->
			<button class="btn btn-link text-light p-0 ms-2 d-md-none" id="sidebarToggle" style="z-index: 1050;">
				<i class="fas fa-bars fs-4"></i>
			</button>

			<!-- Sidebar -->
			<div class="col-md-2 col-3 p-3 vh-100 d-flex flex-column" id="sidebar"
				style="border-right: 1px solid #444; transition: width 0.5s; color:rgb(27 27 27)">
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
					@foreach ($groupedChats as $groupName => $chatList)
						@if (!empty($chatList))
							<li class="text-white" style="font-size: .75rem;line-height: 2rem">{{ $groupName }}</li>
							@foreach ($chatList as $ch)
								<a href="{{ route('chat.details', $ch->id) }}" class="text-light text-decoration-none">
									<li
										class="list-group-item border-0 p-3 mb-2 bg-dark text-light d-flex align-items-center justify-content-between chat-item"
										data-id="{{ $ch->id }}"
										style="height: 35px; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; border-radius:.5rem!important">
										<small class="text-truncate" style="max-width: calc(100% - 30px);">
											{{ $ch->title }}
										</small>
									</li>
								</a>
							@endforeach
						@endif
					@endforeach
				</ul>
			</div>

			<!-- Main Chat Area -->
			<div class="col-md-10 col-9 d-flex flex-column vh-100" id="mainChatArea" style="background-color: #252424;">
				<div class="bg-secondary text-white p-3 d-flex justify-content-between align-items-center">
					<h5 class="m-0">Legal Documents Chatbot</h5>
				</div>

				<!-- Chat Messages Area -->
				<div class="chat-area p-4 overflow-auto flex-grow-1" id="chat-history">
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
					@else
						<!-- Placeholder message -->
						<div class="placeholder-message text-center text-white"
							style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
                          font-style: normal; padding: 20px 30px; border-radius: 15px; ">
							<h3 style="font-size: 2rem; font-weight: bold; margin-bottom: 10px;">Welcome to Your Legal Assistant!</h3>
							<h5 style="font-size: 1.25rem; margin-bottom: 15px;">I'm a chatbot powered by legal documents to answer your
								questions.</h5>
							<h6 style="font-size: 1rem; font-weight: lighter; color: #bbb;">How can I assist you today?</h6>
						</div>
					@endif
				</div>


				<!-- Message Input Area -->
				<div class="input-area position-absolute start-50 translate-middle-x p-3"
					style="
                            bottom: 20px;
                            width: calc(100% - 60px); /* Auto adjust to chat container */
                            max-width: 650px; /* Prevents it from being too large */
                            border-radius: 25px;
                            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
                            backdrop-filter: blur(10px);
                            z-index: 1050;
                        ">
					<form id="chat-form" class="d-flex align-items-center w-100" method="POST">
						@csrf
						<div class="flex-grow-1 position-relative">
							<textarea class="form-control text-light border-0 px-4 py-3" name="message" id="message"
							 placeholder="Send a message..." rows="1"
							 style="
                                border-radius: 20px;
                                background-color: #424242;
                                resize: none;
                                overflow: hidden;
                                box-shadow: none;"
							 required></textarea>
						</div>
						<button class="btn btn-primary d-flex align-items-center justify-content-center ms-2" type="button"
							onclick="sendMessage(this)"
							style="
                                width: 45px; height: 45px;
                                border-radius: 50%;
                                background: #424242;
                                border: none;
                                box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
							<i class="fa fa-arrow-up" aria-hidden="true"></i>
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

		function closeSidebar() {
			sidebar.style.width = "0"; // Close sidebar
			sidebar.style.borderRight = "0px solid rgb(68, 68, 68)"; // Remove border
			sidebar.classList.remove("p-3");
			mainChatArea.style.marginLeft = "0"; // Expand main chat area
			mainChatArea.style.removeProperty('display'); // Remove the display property
		}

		function openSidebar() {
			sidebar.classList.add("p-3");
			sidebar.style.borderRight = "1px solid rgb(68, 68, 68)"; // Apply border
			sidebar.style.width = "300px"; // Open sidebar

			// Hide the mainChatArea when the sidebar is open
			mainChatArea.style.setProperty('display', 'none', 'important'); // Add display: none !important

			// Adjust mainChatArea margin if on larger screens
			if (window.innerWidth > 768) {
				mainChatArea.style.marginLeft = "300px"; // Adjust main chat area only on larger screens
			}
		}

		// Close sidebar on mobile by default
		if (window.innerWidth <= 768) {
			closeSidebar();
		}

		if (sidebarToggle && sidebar && mainChatArea) {
			sidebarToggle.addEventListener('click', function() {
				const isClosed = sidebar.style.width === "0px" || sidebar.style.width === "";
				if (isClosed) { // Open sidebar
					openSidebar();
				} else { // Close sidebar
					closeSidebar();
				}
			});

			// Handle window resize to adjust behavior dynamically
			window.addEventListener("resize", function() {
				if (window.innerWidth <= 768) {
					closeSidebar();
				} else {
					mainChatArea.style.display =
						"flex"; // Ensure mainChatArea is visible on larger screens
				}
			});
		}
	});



	document.addEventListener('DOMContentLoaded', function() {
		const chatArea = document.getElementById('chat-history');
		if (chatArea) {
			// Scroll to the bottom
			chatArea.scrollTop = chatArea.scrollHeight;
		}
	});
</script>

<script>
	function sendMessage(button) {
		const messageInput = document.getElementById('message');
		const message = messageInput.value.trim();
		const chatArea = document.getElementById('chat-history');

		if (!message) {
			return;
		}

		// Remove the placeholder message if it exists
		const placeholderMessage = document.querySelector('.placeholder-message');
		if (placeholderMessage) {
			placeholderMessage.style.display = 'none'; // Hide the placeholder message
		}

		// Create and append the user message
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

		// Create and append the typing animation
		const typingAnimation = document.createElement('div');
		typingAnimation.classList.add('message', 'bot-message', 'mb-3', 'p-3', 'rounded');
		typingAnimation.style.display = 'flex'; // Ensure dots are side by side
		typingAnimation.innerHTML = `
        <div class="typing-animation"></div>
        <div class="typing-animation"></div>
        <div class="typing-animation"></div>
    `;
		chatArea.appendChild(typingAnimation);

		chatArea.scrollTop = chatArea.scrollHeight;

		// Send the message via AJAX
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

				// Remove the typing animation
				chatArea.removeChild(typingAnimation);

				// Create and append the bot's response
				const botMessage = document.createElement('div');
				botMessage.classList.add('message', 'bot-message');

				// Check if the response contains Arabic characters
				const isArabic = /[\u0600-\u06FF]/.test(data.response);
				botMessage.setAttribute('dir', isArabic ? 'rtl' : 'ltr');

				// Convert Markdown to HTML (if needed)
				const parsedResponse = new showdown.Converter().makeHtml(data.response);
				botMessage.innerHTML = `<span style="white-space: pre-line;">${parsedResponse}</span>`;

				// Append the bot message to the chat area
				chatArea.appendChild(botMessage);

				chatArea.scrollTop = chatArea.scrollHeight;
			},
			error: function(xhr, status, error) {
				console.error('Error sending message:', error);

				// Remove the typing animation
				chatArea.removeChild(typingAnimation);

				// Show an error message
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
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const currentUrl = window.location.href;
		const matches = currentUrl.match(/\/(\d+)$/); // Extract ID from the URL
		const activeChatId = matches ? matches[1] : null;

		document.querySelectorAll('.chat-item').forEach(item => {
			if (item.getAttribute('data-id') === activeChatId) {
				item.classList.add('active-chat'); // Add active class
			}

			// Hover effect: Highlight only when hovered
			item.addEventListener('mouseover', function() {
				this.classList.add('hover-chat');
			});

			item.addEventListener('mouseleave', function() {
				this.classList.remove('hover-chat');
			});
		});
	});
</script>
