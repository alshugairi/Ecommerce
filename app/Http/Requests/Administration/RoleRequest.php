<?php

namespace App\Http\Requests\Administration;

use Illuminate\{Foundation\Http\FormRequest};

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $roleId = $this->route('role');

        if ($this->method() === 'POST') {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:roles'];
        } else {
            $rules['name'] = ['required', 'string', 'max:255', 'unique:roles,name,' . $roleId];
        }
        $rules['role_permissions'] = ['required','array'];
        $rules['role_permissions.*'] = ['required','string','exists:permissions,name'];
        return $rules;
    }
}
