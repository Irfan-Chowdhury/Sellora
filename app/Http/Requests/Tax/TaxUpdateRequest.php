<?php

namespace App\Http\Requests\Tax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TaxUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:taxes,name,'.$this->tax_id.',id',
            'rate' => 'required|integer',
        ];
    }
}
