@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="header__logo">FashionablyLate</div>
</header>

@section('content')

<div class="confirm-title">Confirm</div>

<form action="/thanks" method="POST">
    @csrf

    <table class="confirm-table">
        <tr>
            <th>お名前</th>
            <td>{{ $contact['last_name'] }} {{ $contact['first_name'] }}</td>
        </tr>
        <tr>
            <th>性別</th>
            <td>{{ $contact['gender_label'] ?? '未選択' }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $contact['email'] }}</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>{{ $contact['tel1'] }}-{{ $contact['tel2'] }}-{{ $contact['tel3'] }}</td>
        </tr>
        <tr>
            <th>住所</th>
            <td>{{ $contact['address'] }}</td>
        </tr>
        <tr>
            <th>建物名</th>
            <td>{{ $contact['building_name'] ?? '(未入力)' }}</td>
        </tr>
        <tr>
            <th>お問い合わせの種類</th>
            <td>{{ $contact['category_name'] ?? '未選択' }}</td>
        </tr>
        <tr>
            <th>お問い合わせ内容</th>
            <td>{{ $contact['inquiry'] }}</td>
        </tr>
    </table>

    {{-- hidden送信用 --}}
    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
    <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
    <input type="hidden" name="email" value="{{ $contact['email'] }}">
    <input type="hidden" name="tel1" value="{{ $contact['tel1'] }}">
    <input type="hidden" name="tel2" value="{{ $contact['tel2'] }}">
    <input type="hidden" name="tel3" value="{{ $contact['tel3'] }}">
    <input type="hidden" name="address" value="{{ $contact['address'] }}">
    <input type="hidden" name="building_name" value="{{ $contact['building_name'] }}">
    <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
    <input type="hidden" name="inquiry" value="{{ $contact['inquiry'] }}">

    <div class="button-group">
        <button type="submit" name="submit" formaction="/thanks" formmethod="POST" class="submit-button">送信</button>
        <button type="submit" name="back" formaction="/confirm" formmethod="POST" class="back-button">修正</button>      
    </div>
</form>
@endsection