<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        </div>
    @endif
    <form action="{{ route('sendmail') }}" method="post">

        <input type="email" name="email" placeholder="mailaddress">
        <input type="text" name="title" placeholder="title">
        <button type="submit">send email!</button>
        {{ csrf_field() }}
    </form>
</div>
</body>
</html>
