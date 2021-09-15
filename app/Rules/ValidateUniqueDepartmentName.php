<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\DBQueries\Department;

class ValidateUniqueDepartmentName implements Rule
{
    use Department;

    private $department_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($department_id)
    {
        $this->department_id = $department_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $department = $this->first_department('department_id', 'department_name = "'.$value.'"');

        if ($department)
        {
            if ($department->department_id != $this->department_id)
                return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Department Name must be unique.';
    }
}
