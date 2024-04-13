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

    protected function prepareForValidation()
    {
        $data = $this->input(); // リクエストデータを取得する
    
        // 生年月日を整形
        $birth_day = date('Y-m-d', strtotime($data['old_year'] . '-' . $data['old_month'] . '-' . $data['old_day']));
        
        $this->merge([
            'birth_day' => $birth_day
        ]);
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
            'birth_day' => 'required|date_format:Y-m-d|after:2000-01-01|before:today',
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
            'under_name_kana.required' => 'メイは必須です。',
            'under_name_kana.regex' => 'メイはカタカナで入力してください。',
            'under_name_kana.max' => 'メイは30文字以内で入力してください。',
            'birth_day.after' => '生年月日は2000年1月1日からで入力。',
        ];
    }
}
