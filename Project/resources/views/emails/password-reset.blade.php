<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Password Reset</title>
	<style>
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', Arial, sans-serif; color:#222; }
		.container { max-width: 560px; margin: 0 auto; padding: 24px; }
		.btn { display:inline-block; padding: 10px 16px; background:#0d6efd; color:#fff !important; text-decoration:none; border-radius:6px; }
		.muted { color:#6c757d; font-size: 14px; }
	</style>
	</head>
<body>
	<div class="container">
		<h2>Password Reset Request</h2>
		<p>Hello,</p>
		<p>You requested a password reset for your BountyBust account. Click the button below to reset your password.</p>

		<p>
			<a class="btn" href="{{ route('password.reset', ['token' => $token]) }}?email={{ urlencode($email) }}">Reset Password</a>
		</p>

		<p class="muted">
			This link will expire in 24 hours.
		</p>

		<p>If you didn't request a password reset, you can ignore this email.</p>

		<p>Thanks,<br>{{ config('app.name') }}</p>
		<p class="muted">If the button doesn't work, copy and paste this URL into your browser:<br>
			{{ route('password.reset', ['token' => $token]) }}?email={{ urlencode($email) }}
		</p>
	</div>
</body>
</html>
