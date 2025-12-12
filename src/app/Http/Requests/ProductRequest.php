<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $imageRule = $this->isMethod('post')
        ? ['required', 'file', 'mimes:png,jpeg']
        : ['nullable', 'file', 'mimes:png,jpeg'];
        return [
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'between:0,10000'],
            'image' => $imageRule,
            'season' => ['required', 'array', 'min:1'],
            'season.*' => ['integer', 'exists:seasons,id'],
            'description' => ['required', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名を文字列で入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.file' => '商品画像を正しくアップロードしてください',
            'image.mimes' => '「png」または「jpeg」形式でアップロードしてください',
            'season.required' => '季節を選択してください',
            'season.array' => '季節を選択してください',
            'season.min' => '季節を選択してください',
            'season.*.integer' => '季節を正しく選択してください',
            'season.*.exists' => '季節を正しく選択してください',
            'description.required' => '商品説明を入力してください',
            'description.string' => '商品説明を文字列で入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }
}
