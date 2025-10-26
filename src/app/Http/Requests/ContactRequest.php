<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required|integer',
            'first_name'  => 'required|string|max:50',
            'last_name'   => 'required|string|max:50',
            'gender'      => 'required|in:1,2,3',
            'email'       => 'required|email',
            'tel1'       => 'required|digits:3',
            'tel2'       => 'required|digits_between:3,4',
            'tel3'       => 'required|digits:4',
            'address'     => 'required|string|max:100',
            'building_name'    => 'nullable|string|max:100',
            'inquiry'      => 'required|string|max:120',
        ];
    }
     public function messages()
    {
        return [
            'first_name.required' => '姓を入力してください',
            'last_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号を入力してください',
            'tel1.regex' => '電話番号は半角数字で入力してください',
            'tel1.max' => '電話番号は5桁までの数字で入力してください',
            'tel2.required' => '電話番号を入力してください',
            'tel2.regex' => '電話番号は半角数字で入力してください',
            'tel2.max' => '電話番号は5桁までの数字で入力してください',
            'tel3.required' => '電話番号を入力してください',
            'tel3.regex' => '電話番号は半角数字で入力してください',
            'tel3.max' => '電話番号は5桁までの数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'inquiry.required' => 'お問い合わせの内容を入力してください',
            'inquiry.max' => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }
}



