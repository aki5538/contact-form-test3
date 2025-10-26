@extends('layouts.app') {{-- 共通レイアウトを継承 --}}

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('header-button')
<a href="{{ route('login') }}" class="header__login">login</a>
@endsection

@section('content')
<h2 class="register-title">Register</h2>

<div class="register-container">

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group">
            <div>
                <label for="name">お名前</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="例）山田 太郎">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="例）test@example.com">
                @error('email')
                    <div style="error">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password">パスワード</label>
                <input type="password" name="password" placeholder="例）case4rrocks">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit">登録</button>
    </form>
</div>
@endsection