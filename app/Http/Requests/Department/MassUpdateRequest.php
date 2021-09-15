<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidateUniqueDepartmentName;

class MassUpdateRequest extends FormRequest
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
        $rules = [];

        foreach ($this->department_id as $i => $id)
        {
            $rules = array_merge($rules, [
                'department_name.'.$i => ['required', new ValidateUniqueDepartmentName($id)],
            ]);
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'department_name.*.required' => 'Department Name field is required.',
        ];
    }
}
