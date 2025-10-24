<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inika&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__logo">FashionablyLate</div>
        @if (Route::currentRouteName() === 'register')
            <a class="header__login" href="{{ route('login') }}">login</a>
        @elseif (Route::currentRouteName() === 'login')
            <a class="header__login" href="{{ route('register') }}">register</a>
        @endif
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>
