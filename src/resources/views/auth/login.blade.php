@extends('layouts.app') {{-- レイアウトがある場合 --}}

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection



@section('content')
<h1 class="login-title">Login</h1>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="input-group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="ex. test@example.com" required>
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

    <label for="password">パスワード</label>
    <input type="password" name="password" placeholder="ex. coachtechinfo" required>
    @error('password')
        <p class="error">{{ $message }}</p>
    @enderror

    <button type="submit" class="login-button">ログイン</button>

    <div class="register-link">
        <a href="{{ route('register') }}">register</a>
    </div>
</form>
@endsection