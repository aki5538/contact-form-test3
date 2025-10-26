@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('header-button')
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="logout-button">logout</button>
</form>
@endsection

@section('content')
<div class="container">
    <h1>Admin</h1>
</div>
@endsection

    {{-- 🔍 検索フォーム --}}
    <form method="GET" action="/search">
        <input type="text" name="name" placeholder="お名前" value="{{ request('name') }}">
        <input type="email" name="email" placeholder="メールアドレス" value="{{ request('email') }}">
        <select name="gender">
            <option value="">性別</option>
            <option value="全て" {{ request('gender') == '全て' ? 'selected' : '' }}>全て</option>
            <option value="男性" {{ request('gender') == '男性' ? 'selected' : '' }}>男性</option>
            <option value="女性" {{ request('gender') == '女性' ? 'selected' : '' }}>女性</option>
            <option value="その他" {{ request('gender') == 'その他' ? 'selected' : '' }}>その他</option>
        </select>
        <input type="text" name="contact_type" placeholder="お問い合わせ種類" value="{{ request('contact_type') }}">
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit">検索</button>
        <button type="submit" name="reset" value="1">リセット</button>
    </form>

    {{-- 📤 CSV出力 --}}
    <form method="POST" action="/export">
        @csrf
        <input type="hidden" name="name" value="{{ request('name') }}">
        <input type="hidden" name="email" value="{{ request('email') }}">
        <input type="hidden" name="gender" value="{{ request('gender') }}">
        <input type="hidden" name="contact_type" value="{{ request('contact_type') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
        <button type="submit">エクスポート</button>
    </form>

    {{-- 📋 一覧テーブル --}}
    <table>
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせ種類</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
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

    {{-- 📄 ページネーション --}}
    {{ $contacts->links() }}

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
