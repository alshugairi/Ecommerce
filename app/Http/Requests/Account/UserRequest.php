<?php

namespace App\Http\Requests\Account;

use Illuminate\{Foundation\Http\FormRequest};

class UserRequest extends FormRequest
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
        $user = $this->route(param: 'user');

        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['email'] = [
            'required',
            'email',
            'regex:/(.+)@(.+)\.(.+)/i',
            'max:255',
            'unique:users,email,'.$user?->id.',id'
        ];
        $rules['phone'] = [
            'required',
            'numeric',
            'unique:users,phone,'.$user?->id.',id'
        ];
        $rules['role'] = ['required', 'string', "exists:roles,name"];
        //$rules[User::photoField()] = ['nullable', 'image', 'max:1024'];

        if (!$user) {
            $rules['password'] = ['required', 'string', 'min:8', 'same:password-confirmation'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:8', 'same:password-confirmation'];
        }
        return $rules;
    }
}
