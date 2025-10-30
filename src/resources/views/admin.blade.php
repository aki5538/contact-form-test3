@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<header class="header">
    <div class="header__logo">FashionablyLate</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-button">logout</button>
    </form>
</header>

<main>
    <div class="admin-title">Admin</div>
    <div class="admin-container">


    {{-- 🔍 検索フォーム --}}
    <div class="search-form">
        <form method="GET" action="/search" class="search-form__inner">
            <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}"  class="search-input">
            <select name="gender" class="search-select">
                <option value="">性別</option>
                <option value="全て" {{ request('gender') == '全て' ? 'selected' : '' }}>全て</option>
                <option value="男性" {{ request('gender') == '男性' ? 'selected' : '' }}>男性</option>
                <option value="女性" {{ request('gender') == '女性' ? 'selected' : '' }}>女性</option>
                <option value="その他" {{ request('gender') == 'その他' ? 'selected' : '' }}>その他</option>
            </select>

            <input type="text" name="contact_type" placeholder="お問い合わせ種類" value="{{ request('contact_type') }}" class="search-input">
            <input type="date" name="date" value="{{ request('date') }}" class="search-date">
        
            <button type="submit" class="search-button">検索</button>
            <button type="submit" name="reset" value="1" class="reset-button">リセット</button>
        </form>
    </div>

    {{-- 📤 CSV出力 --}}
    <div class="table-controls">

        <form method="POST" action="/export" class="export-form">
            @csrf
            <input type="hidden" name="name" value="{{ request('name') }}">
            <input type="hidden" name="email" value="{{ request('email') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            <input type="hidden" name="contact_type" value="{{ request('contact_type') }}">
            <input type="hidden" name="date" value="{{ request('date') }}">
            <button type="submit" class="export-button">エクスポート</button>
        </form>

        {{-- 📄 ページネーション --}}
        <div class="pagination-wrapper">
            {{ $contacts->links('vendor.pagination.default') }}      
        </div>
    </div>

    {{-- 📋 一覧テーブル --}}
    <div class="background-band">
        <div class="table-wrapper">
            <table class="inquiry-table">
                <thead>
                    <tr class="table-header">
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせ種類</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->gender }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->contact_type }}</td>
                        <td>
                            <button class="detail-btn" data-contact='@json($contact)'>詳細</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    {{-- 🪟 モーダルウィンドウ --}}
    <div id="detail-modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>お名前: <span id="modal-name"></span></p>
            <p>性別: <span id="modal-gender"></span></p>
            <p>メールアドレス: <span id="modal-email"></span></p>
            <p>電話番号: <span id="modal-tell"></span></p>
            <p>住所: <span id="modal-address"></span></p>
            <p>建物名: <span id="modal-building"></span></p>
            <p>お問い合わせ内容: <span id="modal-detail"></span></p>
            <form method="POST" action="/delete" id="delete-form">
                @csrf
                <input type="hidden" name="id" id="delete-id">
                <button type="submit">削除</button>
            </form>
        </div>
    </div>


{{-- 🧠 モーダル制御JS --}}
<script>
document.querySelectorAll('.detail-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const contact = JSON.parse(btn.dataset.contact);
        document.getElementById('modal-name').textContent = contact.last_name + ' ' + contact.first_name;
        document.getElementById('modal-gender').textContent = contact.gender;
        document.getElementById('modal-email').textContent = contact.email;
        document.getElementById('modal-tell').textContent = contact.tell || '';
        document.getElementById('modal-address').textContent = contact.address || '';
        document.getElementById('modal-building').textContent = contact.building || '';
        document.getElementById('modal-detail').textContent = contact.detail || '';
        document.getElementById('delete-id').value = contact.id;
        document.getElementById('detail-modal').style.display = 'block';
    });
});

document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('detail-modal').style.display = 'none';
});
</script>
</div>
</main>
@endsection