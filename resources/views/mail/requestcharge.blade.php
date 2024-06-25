<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yêu cầu nạp tiền</title>
</head>

<body>
    <h2>Bạn có 1 yêu cầu nạp tiền mới từ {{ $user->name }}</h2>
    <h4>Click vào đây để xem: <a href="{{ route('admin.requests.index') }}">Click</a></h4>
</body>

</html>
