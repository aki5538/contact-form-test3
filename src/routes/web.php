<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ユーザー側（未ログインOK）
Route::get('/', [ContactController::class, 'index']); // トップページ(入力画面)
Route::post('/confirm', [ContactController::class, 'confirm']); // 確認画面
Route::post('/thanks', [ContactController::class, 'store']); // 完了画面


// 管理者側（ログイン必須）
Route::middleware('auth')->group(function () {
    Route::get('/admin', [ContactController::class, 'admin']); // 管理画面
    Route::get('/search', [ContactController::class, 'search']); // 検索
    Route::post('/delete', [ContactController::class, 'destroy']); // 削除
    Route::post('/export', [ContactController::class, 'export']); // CSV出力
});
