<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class UnitUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $unitId = $this->input('unit_id');  // Assumes the unit's ID is passed in the route, e.g., /units/{unit}

        $data = [
            'name' => 'required|string|max:191|unique:units,name,' . $unitId,  // Exclude the current unit from the uniqueness check
            'code' => 'required|string|unique:units,code,' . $unitId,  // Exclude the current unit from the uniqueness check
            'base_unit' => 'nullable|exists:units,id',
            'is_active' => 'boolean',
        ];

        // If base_unit is selected, operation_value becomes required
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
            'code.unique' => 'The unit code has already been taken.',
            'base_unit.exists' => 'The selected base unit is invalid.',
            'operation_value.required' => 'The operation value is required when a base unit is selected.',
            'operation_value.numeric' => 'The operation value must be a number.',
            'is_active.boolean' => 'The is active field must be true or false.',
        ];
    }
}
