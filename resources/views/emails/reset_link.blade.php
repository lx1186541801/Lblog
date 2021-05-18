<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>密码找回</title>
</head>
<body>
	<h1>您正在尝试找回密码</h1>

	<p>请点击下面链接进入下一步操作:
		<a href="{{ route('password.reset', $token) }}">{{ route('password.reset', $token) }}</a>
	</p>

	<p>如果不是本人操作，请忽略此邮件</p>
</body>
</html>