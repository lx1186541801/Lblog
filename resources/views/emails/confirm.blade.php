<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>注册确认链接</title>
</head>
<body>
	<h1>感谢您在{{ env('APP_NAME') }}网站注册</h1>

	<p>请点击下面链接完成注册:
		<a href="{{ route('confirm_email', $user->activation_token) }}">{{ route('confirm_email', $user->activation_token) }}</a>
	</p>

	<p>如果不是本人操作，请忽略此邮件</p>
</body>
</html>