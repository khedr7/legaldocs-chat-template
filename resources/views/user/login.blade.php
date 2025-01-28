<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			background-color: #f0f2f5;
		}

		.card {
			max-width: 400px;
			width: 100%;
			padding: 20px;
		}

		.btn-primary {
			width: 100%;
		}
	</style>
</head>

<body>
	<div class="card shadow-sm">
		<div class="card-body">
			<h3 class="text-center mb-4">Login</h3>
			@if (session('error'))
				<div class="alert alert-danger">{{ session('error') }}</div>
			@endif
			<form method="POST" action="{{ route('login') }}">
				@csrf
				<div class="mb-3">

					<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label for="email" class="form-label">Email address</label>
						<input autofocus required type="email" name="email" id="email"
							class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
						@include('alerts.feedback', ['field' => 'email'])
					</div>

					{{-- <input type="email" class="form-control" id="email" name="email" required autofocus> --}}
				</div>
				<div class="mb-3">
					<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
						<label for="password" class="form-label">Password</label>
						<input required type="password" name="password" id="password"
							class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}">
						@include('alerts.feedback', ['field' => 'password'])
					</div>
					{{-- <input type="password" class="form-control" id="password" name="password" required> --}}
				</div>
				<button type="submit" class="btn btn-primary">Login</button>
			</form>
			<div class="text-center mt-3">
				<a href="{{ route('register_view') }}">Don't have an account? Register</a>
			</div>
		</div>
	</div>
</body>

</html>


<!-- Include PNotify library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css"
	integrity="sha512-7nl+p1joxw4BaxI37ELCqOphI6r6RqSyP99ODeAP2E6EuZ5+xBaBelC6YLQejPmHWhlF5U++odEx+6yhm/IVnw=="
	crossorigin="anonymous" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"
	integrity="sha512-dDguQu7KUV0H745sT2li8mTXz2K8mh3mkySZHb1Ukgee3cNqWdCFMFsDjYo9vRdFRzwBmny9RrylAkAmZf0ZtQ=="
	crossorigin="anonymous"></script>

@if (session('success'))
	<script>
		$(document).ready(function() {
			var notification = new PNotify({
				title: 'Success',
				text: '{{ session('success') }}',
				type: 'success',
				styling: 'bootstrap3',
				addclass: 'bg-success',
				desktop: {
					desktop: true,
					icon: 'feather icon-thumbs-up'
				}
			});
			setTimeout(function() {
				notification.remove();
			}, 5000);
			notification.get().click(function() {
				notification.remove();
			});
		});
	</script>
@endif
@if (session('error'))
	<script>
		$(document).ready(function() {
			var notification = new PNotify({
				title: 'error',
				text: '{{ session('error') }}',
				type: 'error',
				styling: 'bootstrap3',
				addclass: 'bg-error',
				desktop: {
					desktop: true,
					icon: 'feather icon-thumbs-up'
				}
			});
			setTimeout(function() {
				notification.remove();
			}, 5000);
			notification.get().click(function() {
				notification.remove();
			});
		});
	</script>
@endif
