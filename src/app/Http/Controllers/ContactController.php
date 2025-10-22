<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;


class ContactController extends Controller
{
    // トップページ
    public function index()
    {
        $categories = Category::all();
        return view('contact', compact('categories'));
    }

    // 確認画面の表示（バリデーション含む）
    public function confirm(ContactRequest $request)
    {
        $inputs = $request->all();
        $category = Category::find($request->category_id);
        $inputs['category_name'] = $category ? $category->name : '未選択';
        
        // 性別の表示用ラベルを追加
        $genderLabels = [1 => '男性', 2 => '女性', 3 => 'その他'];
        $inputs['gender_label'] = $genderLabels[$request->gender] ?? '未選択'; // 表示用
        $inputs['gender'] = $request->gender; // 数値（1,2,3）




        return view('confirm', ['contact'=>$inputs]);
    }

    // 保存処理 → 完了画面
    public function store(ContactRequest $request)
    {
        
        if ($request->has('back')) {
        return redirect('/')->withInput();
    }
    
    $validated = $request->validated();

    // 電話番号を結合
    $validated['tel'] = $validated['tel1'] . '-' . $validated['tel2'] . '-' . $validated['tel3'];

    Contact::create([
        'category_id' => $validated['category_id'],
        'first_name'  => $validated['first_name'],
        'last_name'   => $validated['last_name'],
        'gender'      => $validated['gender'],
        'email'       => $validated['email'],
        'tel'        => $validated['tel'],
        'address'     => $validated['address'],
        'building'    => $validated['building'] ?? null,
        'message'      => $validated['detail'],
    ]);

    return view('thanks');
}
    // 管理画面（ログイン後）
    public function admin()
    {
        $contacts = Contact::latest()->paginate(7);
        return view('admin', compact('contacts'));
    }

    // 検索機能（管理者用）
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $contacts = Contact::where('last_name', 'like', "%{$keyword}%")
            ->orWhere('first_name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->paginate(7);

        return view('admin', compact('contacts'));
    }

    // 削除機能（管理者用）
    public function delete(Request $request)
    {
        $id = $request->input('id');
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin')->with('status', '削除しました');
    }

    // CSVエクスポート（管理者用）
    public function export()
    {
        // 実装は後で追加（Laravel Excelなど）
        return response()->download(storage_path('exports/contacts.csv'));
    }
}