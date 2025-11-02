<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:brands,name',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
