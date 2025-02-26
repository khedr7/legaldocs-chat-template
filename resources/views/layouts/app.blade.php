<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
	<title>Legal Documents Chatbot</title>
	<!-- Link to CSS -->
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<!-- Link to JavaScript -->
	<script src="{{ asset('js/app.js') }}" defer></script>
	<!-- Font Awesome for Logout Icon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

</head>

<body>
	<div class="container-fluid p-0">
		<!-- Main Content -->
		@yield('content')
	</div>
</body>

</html>
