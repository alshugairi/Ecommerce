<?php

namespace App\Http\Requests\Profile;

use Illuminate\{Foundation\Http\FormRequest};

class ProfileRequest extends FormRequest
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
        $userId = auth()->id();

        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['phone'] = [
            'required',
            'numeric',
            'unique:users,phone,'.$userId.',id'
        ];
        return $rules;
    }
}
