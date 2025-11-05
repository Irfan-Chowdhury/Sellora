<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryUpdateRequest extends FormRequest
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


    public function rules()
    {
        return [
            'name' => 'required|unique:categories,name,'.$this->category_id.',id,deleted_at,NULL',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

    }
}
