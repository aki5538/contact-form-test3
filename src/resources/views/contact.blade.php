@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-form">
    <h1 class="contact-title">Contact</h1>

    <form action="/confirm" method="POST">
        @csrf

        <div class="contact-form-wrapper">

        <div class="form-row">
            <label class="form-label" for="last_name">お名前<span class="required">※</span></label>
            <div class="form-inputs">
                <input type="text" id="last_name" name="last_name" class="name-input" placeholder="例：山田" value="{{ old('last_name') }}">
                <input type="text" id="first_name" name="first_name" class="name-input" placeholder="例：花子" value="{{ old('first_name') }}">
            </div>
            @error('last_name')
                <div class="error">{{ $message }}</div>
            @enderror
            @error('first_name')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="gender-group">
                <label class="gender-label">性別<span class="required">※</span></label>
                <div class="gender-options">
                    <div class="gender-option">
                        <input type="radio" id="gender_male" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }}>
                        <label for="gender_male" class="gender-radio">男性</label>
                    </div>
                    <div class="gender-option">
                        <input type="radio" id="gender_female" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}>
                        <label for="gender_female" class="gender-radio">女性</label>
                    </div>
                    <div class="gender-option">
                        <input type="radio" id="gender_other" name="gender" value="3" {{ old('gender') == 3 ? 'checked' : '' }}>
                        <label for="gender_other" class="gender-radio">その他</label>
                    </div>
                </div>
                @error('gender')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="email-row">
                <label class="email-label" for="email">メールアドレス<span class="required">※</span></label>
                <input type="email" id="email" name="email" class="email-input" placeholder="例：test@example.com" value="{{ old('email') }}">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="tel-row">
                <label class="form-label" for="tel1">電話番号<span class="required">※</span></label>
                <div class="form-inputs">
                    <input type="text" name="tel1" id="tel1" class="form-input" placeholder="080" value="{{ old('tel1') }}">
                    <input type="text" name="tel2" id="tel2" class="form-input" placeholder="1234" value="{{ old('tel2') }}">
                    <input type="text" name="tel3" id="tel3" class="form-input" placeholder="5678" value="{{ old('tel3') }}">
                </div>
            </div>


            @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                <div class="error">電話番号を入力してください</div>
            @endif

            <div class="address-row">
                <label class="address-label" for="address">住所 <span class="required">※</span></label>
                <input type="text" name="address" id="address" class="address-input" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
            </div>
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="building-row">
                <label class="building-label" for="building_name">建物名</label>
                <input type="text" id="building_name" name="building_name" class="building-input" value="{{ old('building_name') }}" placeholder="例: サンライズマンション203">
            </div>

            <div class="category-group">
            <label class="category-label" for="category_id">お問い合わせの種類<span class="required">※</span></label>
            <select name="category_id" id="category_id" class="inquiry-select">
                <option value="" disabled select>選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="inquiry-content-group">
                <label class="inquiry-content-label" for="inquiry">お問い合わせ内容<span class="required">※</span></label>
                <textarea id="inquiry" name="inquiry" class="inquiry-content-textarea" placeholder="お問い合わせ内容を入力してください">{{ old('inquiry') }}</textarea>
            </div>
            @error('inquiry')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="confirm-button-group">
            <button type="submit" class="confirm-button">確認画面</button>
        </div>
    </form>
</div>
@endsection
