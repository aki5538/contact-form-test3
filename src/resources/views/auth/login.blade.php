@extends('layouts.app') {{-- レイアウトがある場合 --}}

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<header class="header">
    <div class="header__logo">FashionablyLate</div>
    <a href="{{ route('register') }}" class="header__login">register</a>
</header>

<h2 class="login-title">Login</h2>
<div class="login-container">

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
</form>
@endsection