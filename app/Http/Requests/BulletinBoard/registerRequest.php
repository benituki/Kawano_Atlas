<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ン゛゜ァ-ォャ-ョーー]+$/u|max:30',
            'mail_address' => 'required|max:100|email|unique:users',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'required|after:2000', // 2000年から今年までの範囲
            'old_month' => 'required|min:1|max:12', // 1から12の範囲
            'old_day' => 'required|min:1|max:31', // 1から31の範囲
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|max:30|min:8'
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '姓は必須です。',
            'over_name.max' => '姓は10文字以内で入力してください。',
            'under_name.required' => '名は必須です。',
            'under_name.max' => '名は10文字以内で入力してください。',
            'over_name_kana.required' => 'セイは必須です。',
            'over_name_kana.regex' => 'セイはカタカナで入力してください。',
            'over_name_kana.max' => 'セイは30文字以内で入力してください。',
            'under_name_kana.required' => 'セイは必須です。',
            'under_name_kana.regex' => 'セイはカタカナで入力してください。',
            'under_name_kana.max' => 'セイは30文字以内で入力してください。',
        ];
    }
}
