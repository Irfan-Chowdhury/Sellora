<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $data = [
            'name' => 'required|string|max:191|unique:units,name',
            'code' => 'required|string|unique:units,code',
            'base_unit' => 'nullable|exists:units,id',
            'is_active' => 'boolean',
        ];

        if ($this->input('base_unit')) {
            $data['operation_value'] = 'required|numeric';
        }

        return $data;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The unit name is required.',
            'name.unique' => 'The unit name has already been taken.',
            'code.required' => 'The code is required.',
            'base_unit.exists' => 'The selected base unit is invalid.',
            'operation_value.numeric' => 'The operation value must be a number.',
            'is_active.boolean' => 'The is active field must be true or false.',
        ];
    }
}
