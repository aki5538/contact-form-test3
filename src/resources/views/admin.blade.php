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

            <select name="contact_type" class="search-select">
                <option value="">お問い合わせ種類</option>
                <option value="商品のお届けについて" {{ request('contact_type') == '商品のお届けについて' ? 'selected' : '' }}>商品のお届けについて</option>
                <option value="商品の交換について" {{ request('contact_type') == '商品の交換について' ? 'selected' : '' }}>商品の交換について</option>
                <option value="商品トラブル" {{ request('contact_type') == '商品トラブル' ? 'selected' : '' }}>商品トラブル</option>
                <option value="ショップへのお問い合わせ" {{ request('contact_type') == 'ショップへのお問い合わせ' ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                <option value="その他" {{ request('contact_type') == 'その他' ? 'selected' : '' }}>その他</option>
                <input type="date" name="date" value="{{ request('date') }}" class="search-date">
        
                <button type="submit" class="search-button">検索</button>
                <button type="submit" name="reset" value="1" class="reset-button">リセット</button>
            </select>
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
                        <td>{{ ['1' => '男性', '2' => '女性', '3' => 'その他'][$contact->gender] ?? '不明' }}</td>
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
    </div>
    {{-- 🪟 モーダルウィンドウ --}}
    <style>
        #detail-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            position: relative;
        }

        .close {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .delete-button {
            background-color: #e53935; /* 赤 */
            color: #fff;               /* 白文字 */
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

    </style>
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
                <button type="submit" class="delete-button">削除</button>
            </form>
        </div>
    </div>


    {{-- 🧠 モーダル制御JS --}}
    <script>
    document.querySelectorAll('.detail-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const contact = JSON.parse(btn.dataset.contact);
            const genderMap = {
                '1': '男性',
                '2': '女性',
                '3': 'その他'
            };
            document.getElementById('modal-name').textContent = contact.last_name + ' ' + contact.first_name;
            document.getElementById('modal-gender').textContent = genderMap[contact.gender];
            document.getElementById('modal-email').textContent = contact.email;
            document.getElementById('modal-tell').textContent = contact.tel || '';
            document.getElementById('modal-address').textContent = contact.address || '';
            document.getElementById('modal-building').textContent = contact.building || '';
            document.getElementById('modal-detail').textContent = contact.message || '';
            document.getElementById('delete-id').value = contact.id;
            document.getElementById('detail-modal').style.display = 'flex';
        });
    });

    document.querySelector('.close').addEventListener('click', () => {
        document.getElementById('detail-modal').style.display = 'none';
    });
    </script>
</main>
@endsection